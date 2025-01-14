<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'osano';

    protected $fillable = ['no', 'po_number', 'po_file', 'client_id', 'address_id', 'quotation_id', 'products', 'description', 'status'];

    protected static function boot()
    {
        parent::boot();

        // Secara otomatis mengatur UUID saat membuat model
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
        static::deleting(function ($model) {
            $model->getProducts()->delete();
            if (!empty($model->po_file) && Storage::exists($model->po_file)) {
                Storage::delete($model->po_file);
            }
        });
    }

    protected $keyType = 'string';
    public $incrementing = false;

    public static function generateNomorSurat()
    {
        // Ambil tanggal sekarang
        $tanggal = Carbon::now();
        // Ambil tahun sekarang
        $tahun = $tanggal->year;

        // Cari nomor surat terakhir untuk tahun yang sama
        $lastNomorSurat = self::whereYear('date', $tahun)
                            ->orderByDesc('no') // Urutkan berdasarkan id atau nomor surat yang terbaru
                            ->first();

        // Ambil nomor urut dari nomor surat terakhir
        $urutanSurat = $lastNomorSurat ? intval(explode('/', $lastNomorSurat->no)[1]) : 0;
        $newNumber = $urutanSurat + 1;
        // Format urutan surat agar memiliki 3 digit
        $urutanSurat = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Ambil bulan dalam format Romawi
        $bulanRomawi = self::convertToRoman($tanggal->month);

        // Format nomor surat: INV/xxx/RSM/X/2024
        $nomorSurat = "RO/{$urutanSurat}/RSM/{$bulanRomawi}/{$tahun}";

        return $nomorSurat;
    }

    // Fungsi untuk mengkonversi angka bulan ke angka romawi
    public static function convertToRoman($month)
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];

        return $romans[$month];
    }

    public function getProducts(){
        return $this->hasMany(PurchaseOrderProduct::class, 'purchase_order_id', 'id');
    }

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function address(){
        return $this->hasOne(ClientAddress::class, 'id', 'address_id');
    }

    public function invoice(){
        return $this->hasOne(Invoice::class, 'purchase_order_id', 'id');
    }

    // Relasi hasMany ke ProcessPurchaseOrder
    public function processOrders()
    {
        return $this->hasMany(ProcessPurchaseOrder::class, 'purchase_order_id');
    }

    // Relasi hasMany ke PurchaseOrderProduct
    public function purchaseOrderProducts()
    {
        return $this->hasMany(PurchaseOrderProduct::class, 'purchase_order_id');
    }

    public function getStatus() {
        $purchaseId = $this->id;

        $products = PurchaseOrderProduct::withTrashed()
            ->where('purchase_order_id', $purchaseId)
            ->get();

        $productIds = $products->pluck('product_id');

        // dan yang memiliki `purchase_id` yang terkait di `ProcessPurchaseOrder`
        $processProductsData = ProcessProduct::whereHas('processOrder', function($query) use ($purchaseId) {
                $query->where('purchase_order_id', $purchaseId);
            })
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id');
        
        // Hitung nilai done_qty, on_process_qty, waiting_qty, dan left_qty untuk setiap produk
        $products = $products->map(function ($product) use ($processProductsData) {
            // Panggil fungsi checkQty untuk menghitung qty terkait
            $qtyData = $this->checkQty($product->product_id, $product->qty, $processProductsData);
    
            // Tambahkan data kalkulasi ke dalam hasil
            $product->done_qty = $qtyData['done_qty'];
            $product->on_process_qty = $qtyData['on_process_qty'];
            $product->waiting_qty = $qtyData['waiting_qty'];
            $product->left_qty = $qtyData['left_qty'];
    
            return $product;
        });
        
        $processOrders = $this->processOrders;
        $sumLeftQty = $products->sum('left_qty');
        $o = null;

        $isWaiting = $processOrders->isEmpty() || $processOrders->every(fn($order) => $order->is_finished == 0);
        $isProcessPartial = $processOrders->count() > 0 && ($processOrders->contains('is_finished', 1) || $sumLeftQty !== 0);
        $isProcessSingle = $processOrders->count() == 1 && $sumLeftQty == 0 && $processOrders->first()->is_finished == 1;
        $isFinished = $processOrders->every(fn($order) => $order->is_finished == 2) && $sumLeftQty == 0;
        // Tentukan nilai status berdasarkan kondisi yang diberikan
        if ($isWaiting) {
            $o = 0;
        } elseif ($isProcessPartial) {
            $o = 1;
        } elseif ($isProcessSingle) {
            $o = 2;
        } elseif ($isFinished) {
            $o = 3;
        }
        return $o;
    }
    
    // Fungsi untuk menghitung qty terkait
    private function checkQty($productId, $purchaseQty, $processProductsData) {
        // Ambil semua ProcessProduct terkait dari hasil yang sudah diambil sebelumnya
        $relatedProcessProducts = $processProductsData->get($productId, collect());
    
        // Inisialisasi variabel untuk menyimpan qty yang selesai, sedang diproses, dan menunggu
        $doneQty = 0;
        $onProcessQty = 0;
        $waitingQty = 0;
    
        // Iterasi melalui setiap ProcessProduct
        foreach ($relatedProcessProducts as $processProduct) {
            $processOrder = $processProduct->processOrder;
    
            // Periksa status proses
            if ($processOrder) {
                if ($processOrder->is_finished == 2) {
                    $doneQty += $processProduct->qty;
                } elseif ($processOrder->is_finished == 1) {
                    $onProcessQty += $processProduct->qty;
                } elseif ($processOrder->is_finished == 0) {
                    $waitingQty += $processProduct->qty;
                }
            }
        }
    
        // Hitung qty yang tersisa
        $leftQty = max(0, $purchaseQty - ($doneQty + $onProcessQty + $waitingQty));
    
        return [
            'done_qty' => $doneQty,
            'on_process_qty' => $onProcessQty,
            'waiting_qty' => $waitingQty,
            'left_qty' => $leftQty
        ];
    }

}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProcessPurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'osano';
    protected $table = 'process_purchase_orders';
    protected $fillable = ['no','purchase_order_id', 'address_id', 'principle_id', 'is_logistic_in_sahara','products', 'logistic_id', 'spk_file', 'surjal_file', 'is_finished', 'description'];

    protected static function boot()
    {
        parent::boot();

        // Secara otomatis mengatur UUID saat membuat model
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
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
        // Hitung urutan surat di tahun yang sama
        $countSurat = self::whereYear('date', $tahun)
                        ->count();
        // Tambah 1 agar menjadi urutan surat yang baru
        $urutanSurat = str_pad($countSurat + 1, 3, '0', STR_PAD_LEFT);
        // Ambil bulan dalam format Romawi
        $bulanRomawi = self::convertToRoman($tanggal->month);
        // Format nomor surat: QT/xxx/RSM/X/2024
        $nomorSurat = "PO/{$urutanSurat}/RSM/{$bulanRomawi}/{$tahun}";

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

    public function principle()
    {
        return $this->belongsTo(Principle::class, 'principle_id');
    }

    public function debt(){
        return $this->hasOne(Debt::class, 'process_id', 'id');
    }

    public function logistic()
    {
        return $this->belongsTo(Logistic::class, 'logistic_id');
    }

    public function address()
    {
        return $this->belongsTo(PrincipleAddress::class, 'address_id');
    }
    
    public function pickup()
    {
        return $this->belongsTo(PrincipleAddress::class, 'address_id');
    }

    public function getProducts()
    {
        return $this->hasMany(ProcessProduct::class, 'process_id', 'id');
    }

    public function purchaseOrder(){
        return $this->hasOne(PurchaseOrder::class, 'id', 'purchase_order_id');
    }

}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InvoiceProcess extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'osano';
    protected $table = 'invoice_process';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Secara otomatis mengatur UUID saat membuat model
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::deleting(function ($model){
            if (!empty($model->proof_paid) && Storage::exists($model->proof_paid)) {
                Storage::delete($model->proof_paid);
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
        $countSurat = self::whereYear('date_paid', $tahun)
                        ->count();
        // Tambah 1 agar menjadi urutan surat yang baru
        $urutanSurat = str_pad($countSurat + 1, 3, '0', STR_PAD_LEFT);
        // Ambil bulan dalam format Romawi
        $bulanRomawi = self::convertToRoman($tanggal->month);
        // Format nomor surat: QT/xxx/RSM/X/2024
        $nomorSurat = "RECEIPT/{$urutanSurat}/RSM/{$bulanRomawi}/{$tahun}";

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

    public function hasJurnal(){
        $addCash = $this->getNameJurnal('receive', $this->invoice->purchaseOrder->client->name, $this->invoice->purchaseOrder->no, $this->invoice->no, $this->no); 
        $jurnal = JurnalEntry::where('name', $addCash)->where('is_generated', 1)->first();
        if ($jurnal) {
            return true;
        }
    }

    public function getNameJurnal($type, $client_name, $ro_no, $inv_no, $process_no){
        if($type == 'receive'){
            return 'Penerimaan pembayaran dari '.$client_name.' berdasarkan RO '.$ro_no.' dan Invoice '.$inv_no.' detail '.$process_no;
        }else{
            return 'Penerimaan pembayaran Piutang dari '.$client_name.' berdasarkan RO '.$ro_no.' dan Invoice '.$inv_no.' detail '.$process_no;
        }
    }
    
    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DebtProcess extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'osano';
    protected $table = 'debt_process';
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
        $nomorSurat = "PAID/{$urutanSurat}/RSM/{$bulanRomawi}/{$tahun}";

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
        $name = $this->getNameJurnal('receive', $this->debt->principle->name, $this->debt->processOrder->no, $this->debt->no, $this->no); 
        $jurnal = JurnalEntry::where('name', $name)->where('is_generated', 1)->first();
        if ($jurnal) {
            return true;
        }
    }

    public function getNameJurnal($type, $principle_name, $ro_no, $debt_no, $process_no){
        if($type == 'payment'){
            return 'Pembayaran hutang ke '.$principle_name.' berdasarkan RO '.$ro_no.' dan Invoice '.$debt_no.' detail '.$process_no;
        }else{
            return 'Membayar hutang ke '.$principle_name.' berdasarkan RO '.$ro_no.' dan Invoice '.$debt_no.' detail '.$process_no;
        }
    }

    public function debt(){
        return $this->belongsTo(Debt::class, 'debt_id', 'id');
    }
}

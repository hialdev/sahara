<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quotation extends Model
{
    use HasFactory;
    protected $connection = 'osano';

    protected $fillable = ['no', 'date', 'client_id', 'for', 'message', 'keterangan', 'products', 'status'];

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
        $nomorSurat = "QT/{$urutanSurat}/RSM/{$bulanRomawi}/{$tahun}";

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

    protected $keyType = 'string';
    public $incrementing = false;

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
}

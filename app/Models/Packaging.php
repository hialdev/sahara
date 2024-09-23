<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Packaging extends Model
{
    use HasFactory;
    protected $connection = 'osano';
    protected $table = 'satuan_packaging';

    protected $fillable = ['name', 'capacity', 'id_satuan_barang'];

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

    public function satuan(){
        return $this->hasOne(Satuan::class, 'id', 'id_satuan_barang');
    }
}

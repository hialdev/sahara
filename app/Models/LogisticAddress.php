<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LogisticAddress extends Model
{
    use HasFactory;
    protected $connection = 'osano';

    protected $fillable = ['logistic_id', 'address_tag', 'address', 'city', 'postal_code', 'telp', 'fax'];
    protected $table = 'logistic_address';
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

}

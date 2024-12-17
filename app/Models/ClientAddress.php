<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ClientAddress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'osano';

    protected $fillable = ['client_id', 'address_tag', 'address', 'city', 'postal_code', 'telp', 'fax'];
    protected $table = 'client_address';
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

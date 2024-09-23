<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProcessPurchaseOrder extends Model
{
    use HasFactory;
    protected $connection = 'osano';
    protected $table = 'process_purchase_orders';
    protected $fillable = ['purchase_order_id', 'principle_id', 'is_logistic_in_sahara', 'logistic_id', 'spk_file', 'surjal_file', 'is_finished', 'description'];

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

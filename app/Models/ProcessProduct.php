<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProcessProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $connection = 'osano';
    protected $table = 'process_purchase_order_products';
    protected $fillable = ['process_id', 'product_id', 'price_buy', 'qty'];
    
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

    // Pada model ProcessOrderProduct
    public function processOrder() {
        return $this->belongsTo(ProcessPurchaseOrder::class, 'process_id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }


}

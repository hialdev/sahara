<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PurchaseOrderProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'osano';

    protected $fillable = ['product_id', 'purchase_order_id', 'packaging_id', 'qty', 'price', 'description'];

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

    public function po(){
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    
    public function packaging(){
        return $this->hasOne(Packaging::class, 'id', 'packaging_id');
    }

    public function processProducts() {
        return $this->hasMany(ProcessProduct::class, 'product_id');
    }
}

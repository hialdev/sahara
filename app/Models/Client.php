<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'osano';

    protected $fillable = ['name', 'email', 'npwp', 'description', 'contact_name', 'contact_email', 'contact_phone'];

    protected static function boot()
    {
        parent::boot();

        // Secara otomatis mengatur UUID saat membuat model
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });

        static::deleting(function ($model) {
            foreach ($model->purchaseOrders as $purchaseOrder) {
                $purchaseOrder->processOrders()->delete();
            }
            $model->purchaseOrders()->delete();
            $model->quotations()->delete();
            $model->addresses()->delete();
        });
    }

    protected $keyType = 'string';
    public $incrementing = false;

    // Relation
    public function addresses()
    {
        return $this->hasMany(ClientAddress::class, 'client_id');
    }

    public function quotations(){
        return $this->hasMany(Quotation::class, 'client_id');
    }

    public function purchaseOrders(){
        return $this->hasMany(PurchaseOrder::class, 'client_id');
    }

}

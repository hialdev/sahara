<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Principle extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $connection = 'osano';

    protected $fillable = ['name', 'email', 'description', 'contact_name', 'contact_email', 'contact_phone'];

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
            $model->process_purchase_orders()->delete();
            $model->addresses()->delete();
        });
    }

    protected $keyType = 'string';
    public $incrementing = false;

    // Relation
    public function addresses()
    {
        return $this->hasMany(PrincipleAddress::class, 'principle_id');
    }

    public function process_purchase_orders(){
        return $this->hasMany(ProcessPurchaseOrder::class, 'principle_id');
    }
}

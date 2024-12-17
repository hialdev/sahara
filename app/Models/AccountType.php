<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AccountType extends Model
{
    use HasFactory;
    protected $connection = 'osano';
    protected $table = 'account_types';
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

        static::deleting(function ($model) {
            foreach ($model->accounts as $acc) {
                $acc->delete();
            }
        });
    }

    protected $keyType = 'string';
    public $incrementing = false;
    
    public function accounts(){
        return $this->hasMany(COA::class, 'account_type');
    }

    public function parents(){
        return COA::where('account_type', $this->id)->where('is_parent', 1)->orderBy('no_code', 'asc')->get();
    }
}

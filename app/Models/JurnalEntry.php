<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JurnalEntry extends Model
{
    use HasFactory;
    protected $connection = 'osano';
    protected $table = 'journal_entries';
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
    }

    protected $keyType = 'string';
    public $incrementing = false;

    public function account(){
        return $this->belongsTo(COA::class, 'chart_of_account_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Otp extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    protected $table = 'otp';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function ($data) {
            if (empty($data->id)) {
                $data->id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'user_id', 'otp',
    ];

}

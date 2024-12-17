<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Setting extends Model
{
    use HasFactory;
    protected $keyType = 'string';
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
        'the_key', 'type_form', 'the_value', 'group_id'
    ];

}

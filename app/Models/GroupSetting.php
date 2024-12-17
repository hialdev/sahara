<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GroupSetting extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'group_settings';

    protected static function booted()
    {
        static::creating(function ($data) {
            if (empty($data->id)) {
                $data->id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'name'
    ];

    public function settings()
    {
        return $this->hasMany(Setting::class, 'group_id');
    }

}

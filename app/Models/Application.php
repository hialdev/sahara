<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Application extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function ($application) {
            if (empty($application->id)) {
                $application->id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'title', 'image', 'icon', 'use_icon', 'description', 'url'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_access', 'application_id', 'role_id');
    }
}

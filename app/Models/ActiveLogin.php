<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveLogin extends Model
{
    use HasFactory;
    protected $table = 'active_login';
    protected $fillable = [
        'uniq_login_id', 'user_id'
    ];
}

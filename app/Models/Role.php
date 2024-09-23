<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as RoleSpatie;

class Role extends RoleSpatie
{
    use HasFactory;
    public function applications()
    {
        return $this->belongsToMany(Application::class, 'role_access', 'role_id', 'application_id');
    }
}

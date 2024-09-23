<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    public function applications()
    {
        return $this->belongsToMany(Application::class, 'role_access', 'role_id', 'application_id');
    }
}

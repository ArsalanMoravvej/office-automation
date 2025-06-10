<?php

namespace Modules\AuthManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function positions()
    {
        return $this->morphedByMany(
            \Modules\AuthManagement\Models\Position::class,
            'model',
            'model_has_roles',
            'role_id',
            'model_id'
        );
    }
}


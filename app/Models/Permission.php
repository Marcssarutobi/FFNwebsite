<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'route_name',
        'create',
        'read',
        'update',
        'delete',
        'access_page',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}

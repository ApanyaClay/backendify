<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiPermission extends Model
{
    protected $fillable = [
        'action',
        'resource',
        'label',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $table = 'api_permissions';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKeyPermission extends Model
{
    protected $fillable = [
        'api_key_id',
        'api_permission_id',
        'status',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $table = 'api_key_permissions';
    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class);
    }
    public function apiPermission()
    {
        return $this->belongsTo(ApiPermission::class);
    }
}

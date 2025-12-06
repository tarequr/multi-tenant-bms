<?php
namespace App\Models;

class Tenant extends TenantModel
{
    protected $fillable = ['name', 'email', 'phone', 'assigned_flat_id', 'tenant_id'];

    public function flat()
    {
        return $this->belongsTo(Flat::class, 'assigned_flat_id');
    }
}

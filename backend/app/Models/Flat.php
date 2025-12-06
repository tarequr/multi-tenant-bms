<?php
namespace App\Models;

class Flat extends TenantModel
{
    protected $fillable = ['flat_number', 'floor', 'status', 'house_owner_id'];

    public function houseOwner()
    {
        return $this->belongsTo(User::class, 'house_owner_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'assigned_flat_id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}

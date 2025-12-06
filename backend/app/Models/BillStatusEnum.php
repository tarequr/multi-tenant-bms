<?php
namespace App\Models;

class BillStatusEnum extends TenantModel
{
    protected $fillable = ['name'];
    protected $casts    = ['id' => 'string'];
}

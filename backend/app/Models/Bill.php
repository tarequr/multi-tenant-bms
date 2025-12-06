<?php
namespace App\Models;

class Bill extends TenantModel
{
    protected $fillable = ['flat_id', 'amount', 'month', 'status', 'bill_category_id'];
    protected $casts    = ['id' => 'string', 'month' => 'date:Y-m-d'];

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function category()
    {
        return $this->belongsTo(BillCategory::class, 'bill_category_id');
    }
}

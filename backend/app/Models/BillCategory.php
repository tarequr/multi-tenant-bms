<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillCategory extends Model
{
    protected $fillable = ['name'];
    protected $casts    = ['id' => 'string'];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}

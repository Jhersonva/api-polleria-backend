<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'sale_date',
        'customer_name',
        'total_amount',
        'paid_amount',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function getTotalAmountAttribute()
    {
        return $this->saleDetails->sum(function ($detail) {
            return $detail->quantity * $detail->unit_price;
        });
    }

    public function getPaidAmountAttribute()
    {
        return $this->salePayments->sum('amount');
    }

    public function salePayments()
    {
        return $this->hasMany(SalePayment::class);
    }

     public function getRemainingAmountAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }
}

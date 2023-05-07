<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'payed',
        'payed_at'
    ];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}

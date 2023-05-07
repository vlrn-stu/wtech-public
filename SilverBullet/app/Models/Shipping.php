<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'country',
        'city',
        'post_code',
        'street_name',
        'street_number',
        'shipped',
        'shipped_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

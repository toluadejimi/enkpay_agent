<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDevice extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'fullname',
        'address',
        'state',
        'lga',
        'phone',
        'phone_no',
        'user_id',
        'order_id',
        'order_amount',
        'status',
    ];
}

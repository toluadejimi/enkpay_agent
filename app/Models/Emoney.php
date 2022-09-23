<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emoney extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'trx_id',
        'type',
        'amount',
        'status',
        'user_id',
        'narration',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_code',
        'customer_name',
        'service_name',
        'service_price',
        'shirt_length',
        'arm_length',
        'shoulder',
        'front_neck', 
        'back_neck',
        'chest',
        'arm_hole',
        'cuff',
        'hip',
        'pant',
        'seat',
        'paincha',
        'branch',
        'taken_on',
        'position' => 0,
    ];
}

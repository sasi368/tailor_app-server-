<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;
      protected $fillable = [
        'order_id',
        'customer_name',
        'service_name',
        'employee_name',
        'position',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddCustomer extends Model
{
    use HasFactory;
      protected $fillable = [
        'customer_name',
        'customer_code',
        'branch',
        'gender',
        'email',
        'contact_no',
        'address',
    ]; 
}

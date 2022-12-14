<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliveries extends Model
{
    protected $table ="deliveries";
    protected $casts = ['productList' => 'array'];
    use HasFactory;
}

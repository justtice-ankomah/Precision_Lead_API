<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table ="coupon";
    protected $fillable =['code','discountAmount','toUserId','addedByAdminId'];
    use HasFactory;
}

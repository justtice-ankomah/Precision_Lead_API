<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RidersLiveLocation extends Model
{
    protected $table ="ridersLiveLocation";
    protected $fillable = ['deliveryId','locationLat','locationLnt', 'locationName','locationDesc'];
    use HasFactory;
}


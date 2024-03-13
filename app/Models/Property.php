<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'address', 'detail','price','image', 'type'  // Add more fields as needed
    ];

      // Define the relationship with bookings
      public function bookings()
      {
          return $this->hasMany(Booking::class);
      }
}

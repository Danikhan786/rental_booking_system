<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'cnic',
        'name',
        'father_name',
        'address',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

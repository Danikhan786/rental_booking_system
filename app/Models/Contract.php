<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        // Add other fields as needed
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

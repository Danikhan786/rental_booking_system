<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'booking_date',
        'booking_end_date',
    ];

   
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

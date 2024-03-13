<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $properties = Property::latest()->paginate(5);
        return view('frontend.index',compact('properties'));
    }
    public function property(){
        return view('frontend.property');
    }
    public function dashboard(){
        $propertyCount = Property::count();
        $bookingCount = Booking::count();
        return view('backend.dashboard' , compact('propertyCount', 'bookingCount'));
    }
    public function backendProperty(){
        return view('backend.properties.index');
    }
    public function backendBooking(){
        return view('backend.booking.index');
    }
}

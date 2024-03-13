<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Contract;
use Auth;
use Illuminate\Support\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with('customers')->get();
        return view('backend.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::all();
        return view('backend.bookings.create', compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_end_date' => 'required|date|after_or_equal:booking_date',
            'customer_cnic' => 'required|array',
            'customer_name' => 'required|array',
            'customer_father_name' => 'required|array',
            'customer_address' => 'required|array',
        ]);

          // Process payment
          $this->processPayment($request);

        $property = Property::findOrFail($request->property_id);
        $user = Auth::user();
    
        // Calculate the duration of the booking
        $bookingStartDate = Carbon::parse($request->booking_date);
        $bookingEndDate = Carbon::parse($request->booking_end_date);
        $bookingDuration = $bookingEndDate->diffInDays($bookingStartDate);
    
        // Check if the booking duration is either 1 day or 6 months
        if ($bookingDuration != 1 && $bookingDuration != 180) { // 180 days = 6 months
            return back()->with('error', 'The property can only be booked for either 1 day or 6 months. Please adjust your booking dates accordingly.');
        }
    
        // Check if the room is already booked for the given date range for the same property
        $existingBookingsSameProperty = Booking::where('property_id', $property->id)
            ->where('booking_date', '<=', $request->booking_end_date)
            ->where('booking_end_date', '>=', $request->booking_date)
            ->exists();
    
        if ($existingBookingsSameProperty) {
            return back()->with('error', 'The property is already booked for the selected date range');
        }
    
         // Redirect to the contract page if booking is for 6 months
         if ($bookingDuration == 180) {
            $customersData = [];
            foreach ($request->customer_cnic as $key => $cnic) {
                $customersData[] = [
                    'cnic' => $cnic,
                    'name' => $request->customer_name[$key],
                    'father_name' => $request->customer_father_name[$key],
                    'address' => $request->customer_address[$key],
                ];
            }
        
            // Serialize the array, encode it as base64, and then pass it in the URL
            $encodedCustomersData = base64_encode(json_encode($customersData));
        
            return redirect()->route('bookings.contract', [
                'propertyId' => $property->id,
                'bookingDate' => $request->booking_date,
                'bookingEndDate' => $request->booking_end_date,
                'customersData' => $encodedCustomersData,
            ]);
        }

        

        // Create the booking
        $booking = new Booking();
        $booking->property_id = $property->id;
        $booking->user_id = $user->id;
        $booking->booking_date = $request->booking_date;
        $booking->booking_end_date = $request->booking_end_date;
        $booking->save();
    
        // Create customers for the booking
        foreach ($request->customer_cnic as $key => $cnic) {
            $customer = new Customer();
            $customer->booking_id = $booking->id;
            $customer->cnic = $request->customer_cnic[$key];
            $customer->name = $request->customer_name[$key];
            $customer->father_name = $request->customer_father_name[$key];
            $customer->address = $request->customer_address[$key];
            $customer->save();
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully');
    }
    


    private function processPayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Property Booking', // You can customize this
                    ],
                    'unit_amount' => $request->property_price * 100, // Amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe_success'),
            'cancel_url' => route('stripe_cancel'),
        ]);

        // Redirect to Checkout
        return redirect()->away($session->url);
    }

    /**
     * Handle successful payment.
     */
    public function success()
    {
        // Logic for successful payment
        return redirect()->route('bookings.index')->with('success', 'Payment is successful');
    }

    /**
     * Handle canceled payment.
     */
    public function cancel()
    {
        // Logic for canceled payment
        return back()->with('error', 'Payment is canceled');
    }

    /**
     * Show the contract page.
     */
    public function contract(Request $request, $propertyId, $bookingDate, $bookingEndDate, $customersData)
    {
        $decodedCustomersData = json_decode(base64_decode($customersData), true);
        return view('backend.bookings.contract', compact('propertyId', 'bookingDate', 'bookingEndDate', 'decodedCustomersData'));
    }
    /**
     * Accept the contract and create the booking.
     */
    public function acceptContract(Request $request)
    {
        // Validate the contract acceptance checkbox
        $request->validate([
            'acceptContract' => 'required|accepted',
            'propertyId' => 'required',
            'bookingDate' => 'required|date',
            'bookingEndDate' => 'required|date|after_or_equal:bookingDate',
            'customer_cnic.*' => 'required',
            'customer_name.*' => 'required',
            'customer_father_name.*' => 'required',
            'customer_address.*' => 'required',
        ]);
    
        // Retrieve necessary data from the request
        $propertyId = $request->input('propertyId');
        $bookingDate = $request->input('bookingDate');
        $bookingEndDate = $request->input('bookingEndDate');
        $customerCnics = $request->input('customer_cnic');
        $customerNames = $request->input('customer_name');
        $customerFatherNames = $request->input('customer_father_name');
        $customerAddresses = $request->input('customer_address');
    
        // Assuming booking duration is in days
        $bookingDuration = Carbon::parse($bookingEndDate)->diffInDays($bookingDate);
    
        // Check if the booking is for 6 months (180 days)
        if ($bookingDuration == 180) {
            // Create the booking
            $booking = new Booking();
            $booking->property_id = $propertyId;
            $booking->user_id = Auth::id(); // Assuming you have user authentication
            $booking->booking_date = $bookingDate;
            $booking->booking_end_date = $bookingEndDate;
            $booking->save();
    
            // Create customers for the booking
                foreach ($customerCnics as $key => $cnic) {
                    $customer = new Customer();
                    $customer->booking_id = $booking->id;
                    $customer->cnic = $customerCnics[$key];
                    $customer->name = $customerNames[$key];
                    $customer->father_name = $customerFatherNames[$key];
                    $customer->address = $customerAddresses[$key];
                    $customer->save();
                }
    
            // Create a contract for the booking
            $contract = new Contract();
            $contract->booking_id = $booking->id;
            $contract->save();
    
            return redirect()->route('bookings.index')->with('success', 'Booking created successfully');
        } else {
            // If the booking is not for 6 months, redirect back with an error message
            return redirect()->route('bookings.index')->with('error', 'Booking duration must be 6 months to accept the contract.');
        }
    }
}
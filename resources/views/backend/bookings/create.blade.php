@extends('layouts.backend')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Create Apartment Booking</p>
                        <a class="btn btn-primary btn-sm ms-auto" href="{{ route('bookings.index') }}"> Back</a>
                    </div>
                </div>
                @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data"
                        id="bookingForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Property Name</label>
                                    <select class="form-control" id="propertyId" name="property_id" required>
                                        <option value="">Select Room</option>
                                        <!-- Room options will be populated here -->
                                        @foreach($properties as $property)
                                        <option value="{{ $property->id }}">{{ $property->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="bookingStartDate">Booking Start Date</label>
                                    <input type="date" class="form-control" id="bookingStartDate" name="booking_date"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="bookingEndDate">Booking End Date</label>
                                    <input type="date" class="form-control" id="bookingEndDate" name="booking_end_date"
                                        required>
                                </div>
                            </div>
                            <!-- Customer Details -->
                            <div class="col-md-10" id="customerFields">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="customerCnic">Customer
                                                CNIC</label>
                                            <input type="text" class="form-control" name="customer_cnic[]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="customerName">Customer Name</label>
                                            <input type="text" class="form-control" name="customer_name[]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="customerFatherName">Father's
                                                Name</label>
                                            <input type="text" class="form-control" name="customer_father_name[]"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="customerAddress">Address</label>
                                            <textarea class="form-control" name="customer_address[]" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success" id="addCustomer"><i
                                        class="fa-solid fa-plus"></i></button>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="paymentMethod">Payment Method</label>
                                    <select class="form-control" id="paymentMethod" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="stripe">Stripe</option>
                                        <!-- Add more payment methods here -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-ms-12">
                                <button type="submit" class="btn btn-primary" id="submitBooking">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("addCustomer").addEventListener("click", function () {
            var customerFields = document.getElementById("customerFields");
            var customerField = document.createElement("div");
            customerField.className = "row";
            customerField.innerHTML = `
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="customerCnic">Customer CNIC</label>
                        <input type="text" class="form-control" name="customer_cnic[]" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="customerName">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name[]" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="customerFatherName">Father's Name</label>
                        <input type="text" class="form-control" name="customer_father_name[]" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="customerAddress">Address</label>
                        <textarea class="form-control" name="customer_address[]" required></textarea>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger removeCustomer"><i class="fa-solid fa-minus"></i></button>
                </div>`;
            customerFields.appendChild(customerField);
        });

        document.getElementById("customerFields").addEventListener("click", function (e) {
            if (e.target && e.target.classList.contains("removeCustomer")) {
                e.target.closest(".row").remove();
            }
        });

        // Disable submit button initially
        document.getElementById("submitBooking").disabled = true;

        // Enable submit button when payment method is selected
        document.getElementById("paymentMethod").addEventListener("change", function () {
            var paymentMethod = document.getElementById("paymentMethod").value;
            if (paymentMethod !== "") {
                document.getElementById("submitBooking").disabled = false;
            } else {
                document.getElementById("submitBooking").disabled = true;
            }
        });
    });
</script>

@endsection

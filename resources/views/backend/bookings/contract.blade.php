@extends('layouts.backend')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex align-items-center">
              <p class="mb-0">Contract Apartment Booking</p>
              <a class="btn btn-primary btn-sm ms-auto" href="{{ route('bookings.index') }}"> Back</a>
            </div>
          </div>
          <div class="card-body">
            <p>
                Apartment Booking Contract<br> 

                This contract is entered into on [Date], between [Landlord's Name], hereinafter referred to as the "Landlord," and [Tenant's Name], hereinafter referred to as the "Tenant." <br>

                1. Rental Property: The Landlord agrees to rent to the Tenant the apartment located at [Address], including [list any amenities or utilities included].
                <br>
                2. Term: The rental term shall begin on [Start Date] and end on [End Date], unless extended or terminated earlier according to the terms herein.
                <br>
                3. Rent: The Tenant agrees to pay a monthly rent of [Rent Amount] on or before the [Day of the Month] of each month.
                <br>
                4. Security Deposit: The Tenant shall provide a security deposit of [Deposit Amount] upon signing this agreement, which shall be returned within [number of days] after the end of the tenancy, less any deductions for damages beyond normal wear and tear.
                <br>
                5. Maintenance and Repairs: The Landlord shall be responsible for maintaining the premises in habitable condition and making necessary repairs, except for damages caused by the Tenant's negligence.
                <br>
                6. Use of Premises: The Tenant agrees to use the premises solely for residential purposes and shall not sublet the apartment without the Landlord's written consent.
                <br>
                7. Utilities: [Specify who is responsible for paying utilities such as water, electricity, gas, etc.]
                <br>
                8. Termination: Either party may terminate this agreement with [number of days] written notice to the other party.
                <br>
                9. Governing Law: This contract shall be governed by the laws of [State/Country].
                <br>
                10. Entire Agreement: This agreement constitutes the entire understanding between the Landlord and the Tenant and supersedes all prior agreements or understandings, whether oral or written.
            </p>
            <form method="POST" action="{{ route('bookings.acceptContract') }}">
                @csrf
                <!-- Include hidden input fields for passing necessary data -->
                <input type="hidden" name="propertyId" value="{{ $propertyId }}">
                <input type="hidden" name="bookingDate" value="{{ $bookingDate }}">
                <input type="hidden" name="bookingEndDate" value="{{ $bookingEndDate }}">
                <!-- Include input fields for customer details -->
                @foreach ($decodedCustomersData as $key => $customer)
                  <input type="hidden" name="customer_cnic[]" value="{{ $customer['cnic'] }}">
                  <input type="hidden" name="customer_name[]" value="{{ $customer['name'] }}">
                  <input type="hidden" name="customer_father_name[]" value="{{ $customer['father_name'] }}">
                  <input type="hidden" name="customer_address[]" value="{{ $customer['address'] }}">
                @endforeach
                <div class="form-group">
                    <label for="acceptContract">Accept Contract</label>
                    <input type="checkbox" id="acceptContract" name="acceptContract" value="1">
                    @error('acceptContract')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Accept Contract and Book</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
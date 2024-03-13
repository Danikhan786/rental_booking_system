@extends('layouts.backend')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Booking</h6>
                </div>
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-primary btn-sm ms-auto" href="{{ route('bookings.create') }}"> Create New Booking</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                        <div class="row p-2">
                            <div class="col-md-12">
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customers</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customers Cnic</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Apartment</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Apartment Price</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Booking Start Date</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Booking End Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bookings as $booking)
                                                <tr>
                                                    <td>
                                                        @foreach ($booking->customers as $customer)
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $customer->name }}</h6>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($booking->customers as $customer)
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $customer->cnic }}</h6>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $booking->property->name }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $booking->property->price }}</p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">{{ $booking->booking_date }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">{{ $booking->booking_end_date }}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

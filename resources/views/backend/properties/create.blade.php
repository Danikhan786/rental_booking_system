@extends('layouts.backend')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex align-items-center">
              <p class="mb-0">Create Apartment Rooms</p>
              <a class="btn btn-primary btn-sm ms-auto" href="{{ route('properties.index') }}"> Back</a>
            </div>
          </div>
          @if ($errors->any())
          <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
          <div class="card-body">
            <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="name" class="form-control-label">Name</label>
                    <input name="name" class="form-control" type="text" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label  class="form-control-label">Address</label>
                    <input class="form-control" name="address" type="text" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="price" class="form-control-label">Price</label>
                    <input class="form-control" name="price" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type" class="form-control-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">Select Room Type</option>
                            <option value="single">Single</option>
                            <option value="family">Family</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="detail" class="form-control-label">Details</label>
                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="detail" class="form-control-label">Image</label>
                    <input type="file" name="image" class="form-control" placeholder="image">
                    </div>
                </div>
                <div class="col-ms-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
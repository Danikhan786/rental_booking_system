@extends('layouts.backend')

@section('content')

  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Properties</h6>
          </div>
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <a class="btn btn-primary btn-sm ms-auto" href="{{ route('properties.create') }}"> Create New Properties</a>
              </div>
            </div>
          @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
          @endif
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">price</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">type</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                @foreach ($properties as $property)
                <tbody>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="/images/{{ $property->image }}"  class="avatar avatar-sm me-3" alt="user1">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{ $property->name }}</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $property->address }} </p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $property->price }} </p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-success">{{ $property->type }}</span>
                    </td>
                    <td class="align-middle">
                      <form action="{{ route('properties.destroy',$property->id) }}" method="POST">    
                        <a class="text-secondary font-weight-bold text-xs" href="{{ route('properties.edit',$property->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
            
                        <button type="submit" class="badge badge-sm bg-gradient-danger">Delete</button>
                    </form>
                      {{-- <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                      </a> --}}
                    </td>
                  </tr>
                </tbody>
                @endforeach
              </table>
              {!! $properties->links() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
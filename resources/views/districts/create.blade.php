@extends('layouts.app')
@section('small-title')
 add district
@endsection
@section('content')
<div class="card card-secondary">
    <div class="card-header">
    <h3 class="card-title">Add District </h3>
    <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
    <i class="fas fa-minus"></i>
    </button>
    </div>
    </div>
    <div class="card-body">
        <form action="{{route('districts.store')}}" method='Post'>
          @csrf
    <div class="form-group">
    <label for="inputEstimatedBudget">District Name</label>
    <input type="text" name="name" id="inputEstimatedBudget" class="form-control">
    @error('name')
    <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
    @enderror
    </div>
    <div class="form-group">
    <label for="gov-select"> City Name</label>
    <select class="form-control form-select-lg d-flex w-25" name="city_id" id="gov-select" aria-label="Default select example">
      <option selected value="">Open this select menu</option>
      @foreach ( $cities as $city )
      <option value="{{$city->id}}">{{$city->name}}</option>
      @endforeach
    </select>
    @error('city_id')
    <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
    @enderror
    </div>

    <input type="submit" value="add district" class="btn btn-success float-right">
  </form>

    </div>
    
    </div>
@endsection
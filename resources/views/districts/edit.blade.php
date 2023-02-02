@extends('layouts.app')
@section('small-title')
 edit district
@endsection
@section('content')
<div class="card card-secondary">
    <div class="card-header">
    <h3 class="card-title">Edit District</h3>
    <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
    <i class="fas fa-minus"></i>
    </button>
    </div>
    </div>
    <div class="card-body">
        <form action="{{route('districts.update',$district->id)}}" method='Post'>
          @csrf
          @method('PATCH')
    <div class="form-group">
    <label for="inputEstimatedBudget">Name</label>
    <input type="text" name="name" value="{{$district->name}}" id="inputEstimatedBudget" class="form-control">
    <input type="hidden" name="id" value="{{$district->id}}" id="inputEstimatedBudget" class="form-control">
    @error('name')
    <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
    @enderror
    </div>
    <div class="form-group">
      <label for="gov-select"> City Name</label>
      <select class="form-control form-select-lg d-flex w-25" name="city_id" id="gov-select" aria-label="Default select example">
        {{-- <option selected value="">Open this select menu</option> --}}
        @foreach ( $cities as $city )
        <option value="{{$city->id}}" @if($district->city_id==$city->id)selected @endif>{{$city->name}}</option>
        @endforeach
      </select>
      @error('city_id')
      <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
      @enderror  
      </div>
  
    <input type="submit" value="edit district" class="btn btn-success float-right">
  </form>

    </div>
    
    </div>
@endsection
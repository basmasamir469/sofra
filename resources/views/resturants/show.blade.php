@extends('layouts.app')
@section('page-title')
resturant Details    
@endsection
@section('small-title')
resturant Details    
@endsection
@section('content')
<div class="col-8">

    <div class="card card-primary card-outline">
    <div class="card-body box-profile">
      <div class="text-center">
        <img class="profile-user-img img-fluid img-square" src="{{url('images/resturants/'.$resturant->image)}}" alt="User profile picture">
      </div>
    <h3 class="profile-username text-center">{{$resturant->name}} 
      @if ($resturant->status==1)
      <span class=" badge badge-success">Opened</span>
      @else
      <span class=" badge badge-secondary">Closed</span>
      @endif
   </h3>
    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <b>Email</b> <a class="float-right">{{$resturant->email}}</a>
      </li>   
      <li class="list-group-item">
        <b>Phone</b> <a class="float-right">{{$resturant->phone}}</a>
        </li>   
      <li class="list-group-item">
      <b>City</b> <a class="float-right">{{$resturant->district->city->name}}</a>
      </li>
      <li class="list-group-item">
      <b>District</b> <a class="float-right">{{$resturant->district->name}}</a>
      </li>
      <li class="list-group-item">
      <b>Delivery Cost</b> <a class="float-right">{{$resturant->delivery_cost}}</a>
      </li>
      <li class="list-group-item">
        <b>Minimum Order</b> <a class="float-right">{{$resturant->minimum_order}}</a>
      </li>
      <li class="list-group-item">
        @if ($resturant->active==1)
        <b>Status</b> <a class="float-right"><span class=" badge badge-success">Active</span>
        </a>
        @else
        <b>Status</b> <a class="float-right"><span class=" badge badge-secondary">Not Active</span>
        </a>
        @endif
      </li>
  
      </ul>
    </div>
    
    </div>
    
    
@endsection
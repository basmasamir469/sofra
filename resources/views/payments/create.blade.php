@extends('layouts.app')
@section('small-title')
 add payment
@endsection
@section('content')
<div class="card card-secondary">
    <div class="card-header">
    <h3 class="card-title">Add payment</h3>
    <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
    <i class="fas fa-minus"></i>
    </button>
    </div>
    </div>
    <div class="card-body">
        <form action="{{route('payments.store')}}" method='Post'>
          @csrf
    <div class="form-group">
      <label for="defaultSelect" class=" form-label"> Resturant:</label>
      <div class="row">
        <div class="col-10">
          <select id="defaultSelect" name="resturant_id"  class="form-control form-select w-50">
              <option value="">select resturant</option>
              @foreach ($resturants as $resturant )
              <option value={{$resturant->id}}>{{$resturant->name}}</option>
              @endforeach
          </select>
          @error('resturant_id')
          <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
          @enderror      
        </div>
      </div>
    </div>
    <div class="form-group">
    <label for="inputEstimatedBudget">payment Name</label>
    <input type="text" name="payment_name" id="inputEstimatedBudget" class="form-control">
    @error('payment_name')
    <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
    @enderror
    </div>
    <div class="form-group">
      <label for="inputEstimatedBudget">payment Cost</label>
      <input type="text" name="payment_cost" id="inputEstimatedBudget" class="form-control">
      @error('payment_cost')
      <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
      @enderror
      </div>
  
    <input type="submit" value="add payment" class="btn btn-success float-right">
  </form>

    </div>
    
    </div>
@endsection
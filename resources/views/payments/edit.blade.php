@extends('layouts.app')
@section('small-title')
 edit payment
@endsection
@section('content')
<div class="card card-secondary">
    <div class="card-header">
    <h3 class="card-title">Edit payment</h3>
    <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
    <i class="fas fa-minus"></i>
    </button>
    </div>
    </div>
    <div class="card-body">
        <form action="{{route('payments.update',$payment->id)}}" method='Post'>
          @csrf
          @method('PATCH')
          <div class="form-group">
            <label for="defaultSelect" class=" col-1 form-label"> Resturant:</label>
                <select id="defaultSelect" name="resturant_id" class="form-control form-select w-50">
                    @foreach ($resturants as $resturant )
                    <option value={{$resturant->id}} @if($payment->resturant_id==$resturant->id) selected @endif>{{$resturant->name}}</option>
                    @endforeach
                </select>
                @error('resturant_id')
                <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                @enderror            
          </div>   
    <div class="form-group">
    <label for="inputEstimatedBudget">Payment Name</label>
    <input type="text" name="name" value="{{$payment->payment_name}}" id="inputEstimatedBudget" class="form-control">
    <input type="hidden" name="id" value="{{$payment->id}}" id="inputEstimatedBudget" class="form-control">
    @error('payment_name')
    <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
    @enderror
    </div>

    <div class="form-group">
      <label for="inputEstimatedBudget">Payment Cost</label>
      <input type="text" name="payment_cost" value="{{$payment->payment_cost}}" id="inputEstimatedBudget" class="form-control">
      @error('payment_cost')
      <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
      @enderror
      </div>

  
    <input type="submit" value="edit payment" class="btn btn-success float-right">
  </form>

    </div>
    
    </div>
@endsection
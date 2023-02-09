@extends('layouts.app')
@section('page-title')
<h1>Payments</h1>
@endsection
@section('small-title')
payments
@endsection
@section('content')
<div class="card">
   <div class="card-header mt-3"> 
              <form method="get" action="{{route('payment_search')}}">
                @csrf
                  <div class="mb-3 row">
                      <label for="defaultSelect" class=" col-1 form-label"> Resturant:</label>
                      <div class="col-md-8">
                          <select id="defaultSelect" name="resturant_id" class=" form-control form-select w-50">
                              <option value="">select resturant</option>
                              @foreach ($resturants as $resturant )
                              <option value={{$resturant->id}}>{{$resturant->name}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>

                  <div class="mb-3 row">
                    <label for="html5-date-input" class="col-md-1 col-form-label"> From :</label>
                    <div class="col-md-4">
                        {{-- <input class="form-control" type="date" name="from" value="" id="html5-date-input"> --}}
                        <input name ="from" type="date" class = "form-control datepicker valid_to" placeholder = "Valid To" data-date-start-date="d" value = "{{date('Y-m-d', strtotime('now'))}}">

                    </div>
                    <label for="html5-date-input" class="col-md-1 col-form-label"> To :</label>
                    <div class="col-md-4">
                        {{-- <input class="form-control" type="date" name="to" value="" id="html5-date-input"> --}}
                        <input name ="to" type="date" class = "form-control datepicker valid_to" placeholder = "Valid To" data-date-start-date="d" value = "{{date('Y-m-d', strtotime('now'))}}">
                    </div>
                </div>
                <div class="row justify-content-end">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Search</button>
                  </div>
                </div>                
              </form>
          {{-- </div> --}}
      {{-- </div> --}}
 </div> 
  <div class="card-body">
    @if($payments->count()>0)
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Resturant Name</th>
          <th>Payment Name</th>
          <th>Cost</th>
          <th>Date</th>
          <th colspan="2">Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($payments as $payment )
        <tr>
          <th scope="row">{{$payment->id}}</th>
          <td>{{$payment->resturant->name}}</td>
          <td>{{$payment->payment_name}}</td>
          <td>{{$payment->payment_cost}}</td>
          <td>{{$payment->created_at}}</td>
          <td><a href="{{route('payments.edit',$payment->id)}}" class="btn btn-warning">Edit</a></td>
            <td>
            <form method="post" action="{{ route('payments.destroy',$payment->id) }}"> 
              @csrf       
              @method('DELETE')
          <input type="submit" class="btn btn-danger" value="Delete">
        </form>
           </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <div class="alert alert-danger" role="alert">
     No data
   </div>
   @endif
  </div>
  </div>
    {!! $payments->render() !!}
  @endsection
  

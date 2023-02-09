@extends('layouts.app')
@section('page-title')
<h1>orders</h1>
@endsection
@section('small-title')
orders
@endsection
@section('content')
<div class="card">
   <div class="card-header mt-3"> 
    {{-- <div class="col-lg-12 margin-tb">
      
        </div>         --}}
        {{-- <div class="card mb-4"> --}}
          {{-- <div class="card-body"> --}}
              <form method="get" action="{{route('order_search')}}">
                @csrf
                  <div class="mb-3 row">
                      <div class="col-md-4">
                          <select id="defaultSelect" name="status" class="form-control form-select w-100">                        
                              <option value="">select status</option>
                              <option value="0">cancelled</option>
                              <option value="1">pending</option>
                              <option value="2">accepted</option>
                              <option value="3">rejected</option>
                              <option value="4">delivered</option>
                          </select>
                      </div>

                      <div class="col-md-4">
                        <select id="defaultSelect" name="resturant_id" class="form-control form-select w-100">
                          <option value="">select resturant</option>
                          @foreach ($resturants as $resturant )
                          <option value={{$resturant->id}}>{{$resturant->name}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                      <button type="submit" class="btn btn-primary">Search</button>
                    </div>  

                  </div>
              </form>
 </div> 
  <div class="card-body">
    @if($orders->count()>0)
    <table class="table table-striped">
      <thead>  
        <tr>
          <th scope="col">#</th>
          <th scope="col">Resturant Name</th>
          <th>Client Name</th>
          <th>Date</th>
          <th>Status</th>
          <th colspan="2">Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($orders as $order )
        <tr>
          <th scope="row">{{$order->id}}</th>
          <td>{{$order->resturant->name}}</td>
          <td>{{$order->client->name}}</td>
          <td>{{$order->created_at}}</td>
          <td>
            @if ($order->status==0)
            <span class=" badge badge-danger">Cancelled</span>
            @elseif($order->status==1)
            <span class=" badge badge-warning">Pending</span>
            @elseif($order->status==2)
            <span class=" badge badge-primary">Accepted</span>
            @elseif($order->status==3)
            <span class=" badge badge-danger">rejected</span>
            @elseif($order->status==4)
            <span class=" badge badge-success">Delivered</span>
            @endif    
            </td>
          <td><a href="{{route('orders.show',$order->id)}}" class="btn btn-primary">Show</a></td>
          <td><a href="{{route('orders.print',$order->id)}}" class="btn btn-secondary">Print</a></td>
            <td>
            <form method="post" action="{{ route('orders.destroy',$order->id) }}"> 
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
    {!! $orders->render() !!}
  @endsection
  

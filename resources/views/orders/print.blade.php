@extends('layouts.app2')
@section('page-title')
order Details    
@endsection
@section('small-title')
order Details    
@endsection
@section('content')
<div class="col-8 mt-5">

    <div class="card card-primary card-outline">
    <div class="card-body box-profile">
    <h3 class="profile-username text-center">Order #{{$order->id}}
   </h3>
    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <b>Resturant Name</b> <a class="float-right">{{$order->resturant->name}}</a>
      </li>  
      <li class="list-group-item">
        <b>Client Name</b> <a class="float-right">{{$order->client->name}}</a>
      </li>  
      <li class="list-group-item">
        @if ($order->status==0)
        <b>Status</b> <a class="float-right"><span class=" badge badge-danger">Cancelled   
      </span>
        </a>
        @elseif($order->status==1)
        <b>Status</b> <a class="float-right"><span class=" badge badge-warning">Pending</span>
        </a>
        @elseif($order->status==2)
        <b>Status</b> <a class="float-right"><span class=" badge badge-primary">Accepted</span>
        </a>
        @elseif($order->status==3)
        <b>Status</b> <a class="float-right"><span class=" badge badge-danger">rejected</span>
        </a>
        @elseif($order->status==4)
        <b>Status</b> <a class="float-right"><span class=" badge badge-success">Delivered</span>
        </a>
        @endif
      </li>     
      <li class="list-group-item">
        <b>Address</b> <a class="float-right">{{$order->address}}</a>
        </li>
        <li class="list-group-item">
          <b>Meals</b>
          <ul class="list-group list-group-unbordered mb-3">
            @foreach ($order->meals as $meal )
              <li class="list-group-item">
              <i>{{$meal->name}}</i> <a class="ml-5">{{$meal->pivot->price}}</a>
              @if($meal->pivot->special_order)
              <i class="ml-5">Special Order</i> <a class="ml-5">{{$meal->pivot->special_order}}</a> 
              @endif
              <i class="ml-5">Quantity</i> <a class="ml-5">{{$meal->pivot->quantity}}</a> 
            </li>  
            @endforeach
          </ul>      
        </li> 
        
        <li class="list-group-item">
          <b>meals cost</b> <a class="float-right">{{$order->meals_cost}}</a>
          </li>    

        <li class="list-group-item">
          <b>Delivery cost</b> <a class="float-right">{{$order->delivery_cost}}</a>
          </li>  
          
          <li class="list-group-item">
            <b>Total cost</b> <a class="float-right">{{$order->total_cost}}</a>
            </li> 
            
            <li class="list-group-item">
              <b>Payment Method</b> <a class="float-right">{{$order->payment_method}}</a>
              </li>        
  
      </ul>
  
    </div>
    
    </div>
    
    
@endsection
@push('scripts')
<script type="text/javascript">
  $(function(){
    window.print();
  })
</script>

@endpush

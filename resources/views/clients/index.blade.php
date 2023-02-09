@extends('layouts.app')
@section('page-title')
<h1>clients</h1>
@endsection
@section('small-title')
clients
@endsection
@section('content')
<div class="card">
   <div class="card-header mt-3"> 
    {{-- <div class="col-lg-12 margin-tb">
      
        </div>         --}}
        {{-- <div class="card mb-4"> --}}
          {{-- <div class="card-body"> --}}
              <form method="get" action="{{route('client_search')}}">
                @csrf
                  <div class="mb-3 row">
                      <div class="col-md-4">
                          <select id="defaultSelect" name="active" class="form-control form-select w-100">
                              <option value="">select status</option>
                              <option value="0">not active</option>
                              <option value="1">active</option>
                          </select>
                      </div>

                      <div class="col-md-4">
                        <select id="defaultSelect" name="city_id" class="form-control form-select w-100">
                            <option value="">select city</option>
                            @foreach ($cities as $city )
                            <option value={{$city->id}}>{{$city->name}}</option>
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
    @if($clients->count()>0)
    <table class="table table-striped">
      <thead>  
        <tr>
          <th scope="col">#</th>
          <th scope="col">client Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>City</th>
          <th>Active</th>
          <th colspan="2">Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($clients as $client )
        <tr>
          <th scope="row">{{$client->id}}</th>
          <td>{{$client->name}}</td>
          <td>{{$client->email}}</td>
          <td>{{$client->phone}}</td>
          <td>{{$client->district->city->name}}</td>
          <td><!-- Default switch -->
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$client->id}}" @if ($client->active===1) checked @else  @endif id="{{'customSwitches'.$client->id}}">
              <label class="custom-control-label" for="{{'customSwitches'.$client->id}}">Activate</label>
            </div></td>  
          <td><a href="{{route('clients.show',$client->id)}}" class="btn btn-primary">Show</a></td>
            <td>
            <form method="post" action="{{ route('clients.destroy',$client->id) }}"> 
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
    {!! $clients->render() !!}
  @endsection
  @push('scripts')
<script type="text/javascript">
  $(function() {
    $('.toggle-class').change(function() {
        var active = $(this).prop('checked') == true ? 1 : 0; 
        var client_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/client/activate',
            data: {'active': active, 'client_id': client_id},
            success: function(data){
              console.log(data.active)
            }
        });
    })
  })
</script>

@endpush
  

@extends('layouts.app')
@section('page-title')
<h1>resturants</h1>
@endsection
@section('small-title')
resturants
@endsection
@section('content')
<div class="card">
   <div class="card-header mt-3"> 
    {{-- <div class="col-lg-12 margin-tb">
      
        </div>         --}}
        {{-- <div class="card mb-4"> --}}
          {{-- <div class="card-body"> --}}
              <form method="get" action="{{route('resturant_search')}}">
                @csrf
                  <div class="mb-3 row">
                      <div class="col-md-4">
                          <select id="defaultSelect" name="resturant_id" class="form-control form-select w-100">
                              <option value="">select resturant</option>
                              @foreach ($selected_resturants as $resturant )
                              <option value={{$resturant->id}}>{{$resturant->name}}</option>
                              @endforeach
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
    @if($resturants->count()>0)
    <table class="table table-striped">
      <thead>  
        <tr>
          <th scope="col">#</th>
          <th scope="col">Resturant Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>City</th>
          <th>Active</th>
          <th colspan="2">Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($resturants as $resturant )
        <tr>
          <th scope="row">{{$resturant->id}}</th>
          <td>{{$resturant->name}}</td>
          <td>{{$resturant->email}}</td>
          <td>{{$resturant->phone}}</td>
          <td>{{$resturant->district->city->name}}</td>
          <td><!-- Default switch -->
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$resturant->id}}" @if ($resturant->active===1) checked @else  @endif id="{{'customSwitches'.$resturant->id}}">
              <label class="custom-control-label" for="{{'customSwitches'.$resturant->id}}">Activate</label>
            </div></td>  
          <td><a href="{{route('resturants.show',$resturant->id)}}" class="btn btn-primary">Show</a></td>
            <td>
            <form method="post" action="{{ route('resturants.destroy',$resturant->id) }}"> 
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
    {!! $resturants->render() !!}
  @endsection
  @push('scripts')
<script type="text/javascript">
  $(function() {
    $('.toggle-class').change(function() {
        var active = $(this).prop('checked') == true ? 1 : 0; 
        var resturant_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/resturant/activate',
            data: {'active': active, 'resturant_id': resturant_id},
            success: function(data){
              console.log(data.active)
            }
        });
    })
  })
</script>

@endpush
  

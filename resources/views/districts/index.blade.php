@extends('layouts.app')
@section('page-title')
<h1>Districts</h1>
@endsection
@section('small-title')
 districts
@endsection

@section('content')
<div class="card">
@if(count($districts)>0)
@include('flash::message')
<div class="card-body">
<table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">District Name</th>
        <th>City Name </th>
        <th colspan="2">Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($districts as $district )
      <tr>
        <th scope="row">{{$district->id}}</th>
        <td>{{$district->name}}</td>
        <td>{{$district->city->name}}</td>
        <td><a href="{{route('districts.edit',$district->id)}}" class="btn btn-warning">Edit</a></td>
          <td>
          <form method="post" action="{{ route('districts.destroy',$district->id) }}"> 
            @csrf       
            @method('DELETE')
        <input type="submit" class="btn btn-danger" value="Delete">
      </form>
         </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
  @else
  <div class="alert alert-danger" role="alert">
   No data
 </div>
 @endif
</div>
  {!! $districts->render() !!}
@endsection
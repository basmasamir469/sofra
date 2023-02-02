@extends('layouts.app')
@section('small-title')
 edit city
@endsection
@section('content')
<div class="card card-secondary">
    <div class="card-header">
    <h3 class="card-title">Edit City</h3>
    <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
    <i class="fas fa-minus"></i>
    </button>
    </div>
    </div>
    <div class="card-body">
        <form action="{{route('cities.update',$city->id)}}" method='Post'>
          @csrf
          @method('PATCH')
    <div class="form-group">
    <label for="inputEstimatedBudget">Name</label>
    <input type="text" name="name" value="{{$city->name}}" id="inputEstimatedBudget" class="form-control">
    <input type="hidden" name="id" value="{{$city->id}}" id="inputEstimatedBudget" class="form-control">
    @error('name')
    <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
    @enderror
    </div>
  
    <input type="submit" value="edit city" class="btn btn-success float-right">
  </form>

    </div>
    
    </div>
@endsection
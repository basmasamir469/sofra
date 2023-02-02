@extends('layouts.app')
@section('page-title')
<h1>contacts</h1>
@endsection
@section('small-title')
contacts
@endsection
@section('content')
<div class="card">
   <div class="card-header mt-3"> 
              <form method="get" action="{{route('contact_search')}}">
                  <div class="mb-3 row">
                      <div class="col-md-12">
                          <select id="defaultSelect" name="status" class="form-control form-select w-50 mb-3">
                              <option value="">choose type</option>
                              <option value="enquiry">Enquiry</option>
                              <option value="complaint">Complaint</option>
                              <option value="suggestion">Suggestion</option>
                          </select>
                            <button type="submit" class="btn btn-primary">Search</button>
                      </div>    
                  </div>
                <div class="row justify-content-end">
                </div>                
              </form>
 </div> 
  <div class="card-body">
    @if($contacts->count()>0)
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Message</th>
          <th>Type</th>
          <th colspan="2">Actions</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($contacts as $contact )
        <tr>
          <th scope="row">{{$contact->id}}</th>
          <td>{{$contact->name}}</td>
          <td>{{$contact->email}}</td>
          <td>{{$contact->phone}}</td>
          <td>{{$contact->message}}</td>
          <td>{{$contact->status}}</td>
            <td>
            <form method="post" action="{{ route('contacts.destroy',$contact->id) }}"> 
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
    {!! $contacts->render() !!}
  @endsection
  

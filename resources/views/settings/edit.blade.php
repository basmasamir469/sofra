@extends('layouts.app')
@section('small-title')
 edit settings
@endsection

@section('content')
@include('flash::message')
<div class="card card-secondary">
    <div class="card-header">
    <h3 class="card-title">Edit Settings</h3>
    <div class="card-tools">
    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
    <i class="fas fa-minus"></i>
    </button>
    </div>
    </div>
    <div class="card-body">
        <form 
        action="{{route('settings.update')}}"
             method='Post' enctype="multipart/form-data">
          @csrf
          @method('PATCH')
            <div class="form-group">
              <label for="inputEstimatedBudget">About App</label>
              <textarea class="form-control" name="about_app" id="exampleFormControlTextarea1" rows="3">{{$settings->about_app}}
              </textarea>
              </div>  
        
              <div class="form-group">
                <label for="inputEstimatedBudget">Phone</label>
                <input type="text" name="phone" value="{{$settings->phone}}" id="inputEstimatedBudget" class="form-control">
                </div>

                <div class="form-group">
                  <label for="inputEstimated">App Comission</label>
                  <input type="text" name="app_comission" value="{{$settings->app_comission}}" id="inputEstimated" class="form-control">
                  </div>  

                <div class="form-group">
                    <h4 class="text-bold">Accounts</h4>
                    @foreach ($settings->accounts as $account => $value )
                    <input type="text" class="form-control w-50" name={{$account}} value={{$account}}>
                    <input type="text" name="accounts[{{$account}}]" value={{$value}} id="inputEstimatedBudget" class="form-control">
                    @endforeach
                    </div>
                 <div class="form-group">
                      <label for="inputEstimatedBudget">Facebook Link</label>
                      <input type="text" name="fb_link" value="{{$settings->fb_link}}" id="inputEstimatedBudget" class="form-control">
                      </div>

                      <div class="form-group">
                        <label for="inputEstimatedBudget">Twitter Link</label>
                        <input type="text" name="tw_link" value="{{$settings->tw_link}}" id="inputEstimatedBudget" class="form-control">
                        </div>

                        <div class="form-group">
                          <label for="inputEstimatedBudget">Insta Link</label>
                          <input type="text" name="insta_link" value="{{$settings->insta_link}}" id="inputEstimatedBudget" class="form-control">
                          </div>
  
    

  
        
            
    <input type="submit" value="update settings" class="btn btn-success float-right">
  </form>

    </div>
    
    </div>
@endsection
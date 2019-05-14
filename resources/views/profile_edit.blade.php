@extends('layouts.app')
@section('content')

@if (!empty($messages))
  @foreach($messages AS $mess)
    <div class="alert alert-info" role="alert"> {{ $mess }} </div>
  @endforeach
@endif

@if ($errors -> any())
   @foreach ($errors->all() as $error)
  	<div class="alert alert-danger" role="alert"> {{ $error }}</div>
  @endforeach
@endif

<div class="container">
  <div class="row">
    <div class="col-sm">
      <form class="form-comment" method="POST" action="/profile/edit">
      	@csrf
        <fieldset disabled>
            <input type="text" class="form-control" id ="staticLogin" value="{{ $user -> name }}">
        </fieldset>

        <br>

        <div class="row">
          <div class="col">
            <input type="text" class="form-control" name="first_name" placeholder="{{$user -> first_name ?? 'First name'}}">
          </div>
        
          <div class="col">
            <input type="text" name = "last_name" class="form-control" placeholder="{{$user -> last_name ?? 'Last name'}}">
          </div>
        </div>
     
        <br>
    
        <div class="form-group row">
         <label for="inputPassword" class="col-sm-2 col-form-label">Old</label>
        
          <div class="col-sm-10">
            <input type="password" name = "old_pass" class="form-control" id="inputOldPassword" placeholder="Old Password" >
          </div>

          <label for="inputPassword" class="col-sm-2 col-form-label">New</label>
        
          <div class="col-sm-10">
            <input type="password" name = "password" class="form-control" id="inputNewPassword" placeholder="New Password" >
          </div>

          <label for="inputPassword" class="col-sm-2 col-form-label">Confirm</label>
        
          <div class="col-sm-10">
            <input type="password" name = "password_confirmation" class="form-control" id="inputConfirmPassword" placeholder="Confirm Password" >
          </div>
        </div>
        
        <div class="row">
          <div class="col">
              <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" 
    			       placeholder="{{$user -> email ?? 'Enter email'}}">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
        </div>
        
        <small class="text-muted">{{ $user -> residence ?? ''}} </small>
        <select class="custom-select my-1 mr-sm-2" name="country_id" id="country_id" class="StyleSelectBox">
          <option value="0">- select country -</option>
          @if (!empty($coutnrys))
            @foreach($coutnrys AS $country)
              <option value="{{$country -> country_id}}">{{$country -> country_name}}</option>
            @endforeach
          @endif
        </select>
        
        <br>
        
        <select class="custom-select my-1 mr-sm-2" name="region_id" id="region_id" disabled="disabled" class="StyleSelectBox">
          <option value="0">- select region -</option><br>
        </select>
        
        <br>
        
        <select class="custom-select my-1 mr-sm-2" name="city_id" id="city_id" disabled="disabled" class="StyleSelectBox">
          <option value="0">- select city -</option>
        </select>
        
        <br>
        <br>
    
        <center>
          <div class="row">
            
            <div class="col">
              <button class="btn btn-primary btn-lg active" name="submit" type="submit">Save</button>
            </div>
             
            <div class="col">
              <div align="center" id="selectBoxInfo"></div>
            </div>
          </div>
        </center>
      </form>
    </div>
  
    <div class="col-sm">
      <br>
  		<center>
        <div class="card" style="width: 16rem;">
          <img class="card-img-top" src="/images/{{$user -> image}}">
        </div>
      </center>
  		
      <br>
      
      <form class="form-comment" action="{{ route('image.upload.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
          <div class="col">
            <input class="form-control" type="file" name="image">
          </div>
          
          <div class="row">
            <button class="btn btn-primary btn-lg active" type="submit">Upload</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
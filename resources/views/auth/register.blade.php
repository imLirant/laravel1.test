@extends('layouts.app')

@section('content')

@if ($errors -> any())
   @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert"> {{ $error }}</div>
  @endforeach
@endif

<script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}" defer></script>
<script type="text/javascript" src="{{ URL::asset('js/selects.js') }}" defer></script>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Register') }}</div>
        
        <div class="card-body">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Login') }}</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
            </div>

            <div class="form-group row">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row">
              <label for="twitter" class="col-md-4 col-form-label text-md-right">{{ __('Twitter') }}</label>
                <div class="col-md-6">
                  <input type="text" name="twitter" class="form-control" id="twitter" required>
                </div>
            </div>

            <div class="form-group row">
              <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>
              <div class="col-md-6">
                <select class="custom-select my-1 mr-sm-2" name="country_id" id="country_id">
                  <option value="0">- select country -</option>
                    @if (!empty($countries))
                      @foreach($countries AS $country)
                        <option value="{{$country -> country_id}}">{{$country -> country_name}}</option>
                      @endforeach
                    @endif
                  </select>
              </div>
            
              <label for="region_id" class="col-md-4 col-form-label text-md-right">{{ __('Region') }}</label>
              <div class="col-md-6">
            
                <select class="custom-select my-1 mr-sm-2" name="region_id" id="region_id" disabled="disabled">
                  <option value="0">- select region -</option><br>
                </select>
              </div>
            
              <label for="city_id" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
              <div class="col-md-6">
      
                <select class="custom-select my-1 mr-sm-2" name="city_id" id="city_id" disabled="disabled">
                  <option value="0">- select city -</option>
                </select>
              </div>
            </div>
            
            
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Register') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

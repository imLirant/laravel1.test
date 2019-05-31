@extends('layouts.app')
@section('content')

@if (Session::has('UserUpdateResut'))
  @foreach(session()->get('UserUpdateResut') AS $mess)
    <div class="alert alert-info" role="alert"> {{ $mess }} </div>
  @endforeach
@endif

@if ($errors -> any())
   @foreach ($errors->all() as $error)
  	<div class="alert alert-danger" role="alert"> {{ $error }}</div>
  @endforeach
@endif
  <profile-edit-page v-bind:user="{{json_encode($user)}}"></profile-edit-page>
@endsection
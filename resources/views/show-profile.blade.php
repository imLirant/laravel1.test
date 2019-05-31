@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
	  <profile-component v-bind:user="{{json_encode($user)}}"></profile-component>
	</div>
	<div class="col-md-12">
	  @if (isset($user) and isset($user -> twitter))
  		<!-- <pooling-component v-bind:delay="30000"> </pooling-component> -->
  		<br>
  		<twitter-component v-bind:user="{ name: '{{$user -> twitter}}', count: 10}"></twitter-component>
	  @endif
	</div>
  </div>
</div>

@endsection
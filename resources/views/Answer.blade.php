@extends('layouts.app')

@section('content')

<div class="container">

<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
	<answer-component></answer-component>
	<twitter-component v-bind:username="elonmusk"></twitter-component>
	<iframe width="980" height="410" src="https://mars.nasa.gov/layout/embed/send-your-name/mars2020/certificate/?cn=412907553486" frameborder="0"></iframe>
  </div>
</div>

@endsection
@extends('layouts.app')
@section('content')

<center>
  <profile-component v-bind:user="{{json_encode($user)}}"></profile-component>
<br>
</center>
@if (isset($user) and isset($user -> twitter))
  <!-- <pooling-component v-bind:delay="30000"> </pooling-component> -->
  <twitter-component v-bind:user="{ name: '{{$user -> twitter}}', count: 10}"></twitter-component>
@endif

@endsection
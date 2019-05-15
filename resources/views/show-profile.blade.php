@extends('layouts.app')
@section('content')

<center>
  <div class="card" style="width: 16rem;">
    @if (isset($user))
      <img class="card-img-top" src="/images/{{$user -> image}}" alt="Card image cap">
    @else
      <img class="card-img-top" src=/images/anonymous-user.jpg alt="Card image cap">
    @endif
    
    <div class="card-body">
      <h5 class="card-title">{{$user -> name?? "Unknown"}}</h5>
        <p class="text-center text-muted">{{$user -> first_name ?? ''}} {{$user -> last_name ?? ''}}</p>
      <p class="text-center text-muted"> {{$user -> residence ?? ''}}</p>
    </div>
  </div>
</center>

@endsection
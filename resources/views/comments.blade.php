@extends('layouts.app')

@section('content')


@if(Session::has('CommentSentResut'))
    <div class="alert alert-info" role="alert"> {{ session()->get('CommentSentResut') }} </div>
@endif

@if ($errors -> any())
   @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert"> {{ $error }}</div>
  @endforeach
@endif

<form method="POST" class="form-comment" action="/comments">
    @csrf
    <input class="form-control" name="theme" type="text" placeholder="Theme" required>
    <textarea class="form-control" name="text" cols="40" rows="5" placeholder="Comment" required></textarea>
    <br>
    <center><input class="btn btn-primary btn-lg active" name="submit" type="submit" value="Send"></center>
</form>

<div class="container">
  <div class="row justify-content-center">
    
  </div>
  @if (!empty($comments))
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Comments</div>
          <div class="card-body">
            <div class="container">
              <div class="row justify-content-md-center">
                {{ $comments }} 
                <div class="col-md-auto">
                  @foreach($comments AS $comm)
                    <div class="card mb-3" style="max-width: 540px;">
                      <div class="row align-items-center">
                        <div class="col-md-4">
                          <img class="card-img-top" src="{{$comm -> user -> getImagePath()}}" alt="Card image cap">              
                        </div>
                  
                        <div class="col-md-8">
                          <div class="card-body">
                            <h5 class="card-title">
                              <a class="nav-link " href="{{$comm -> user -> getProfileUrl()}}">
                                {{$comm -> user -> name}}
                              </a>
                            </h5>
                            
                            <h6 class="card-subtitle mb-2 text-center text-muted">{{ $comm -> theme }}</h6>
                            <p class="card-text mb-2 text-muted">{{ $comm -> text }}</p>
                            <p class="card-text"><small class="text-muted">{{ $comm -> created_at }}</small></p>
                            
                          </div>
                        </div>

                      </div>
                    </div>
                  @endforeach
                </div>
                {{ $comments }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection

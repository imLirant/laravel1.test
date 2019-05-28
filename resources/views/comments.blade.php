@extends('layouts.app')

@section('content')

<div class="container">

<pooling-component v-bind:delay="5000"> </pooling-component>
<commentform-component> </commentform-component>  
<comments-component v-bind:in_page="10"> </comments-component>

</div>

@endsection

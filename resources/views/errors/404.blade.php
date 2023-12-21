@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="container">
    <h1>Page Not Found</h1>
    <p>The page you are looking for could not be found.</p>
    <a href="{{ url('/home') }}">Return to home</a>
</div>
@endsection

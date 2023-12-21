@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="container">
    <h1>Restricted Access</h1>
    <p>The page you are trying to access is of restricted access, and you do not have permissions to view it</p>
    <a href="{{ url('/home') }}">Return to home</a>
</div>
@endsection
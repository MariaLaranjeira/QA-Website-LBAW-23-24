@extends('layouts.app')

@section('title', 'Profile')

@section('styles')
<link href="{{ url('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<section id="profileEdit">

  <div>
    <h2>Edit Your Profile</h2>
    <form action="{{ route('update_user')}}" method="POST">
            {{ csrf_field() }}
            New Name:
            <input id="name" type="text" name="name" placeholder="{{ $user->name }}">

            New Username:
            <input id="username" type="text" name="username" placeholder="{{ $user->username }}">

            New Email:
            <input id="email" type="email" name="email" placeholder="{{ $user->email }}">

            New Password:
            <input id="password" type="password" name="password" placeholder="Password">
            <button type="submit">
                Edit Profile
            </button>
        </form>

  </div>

</section>
@endsection

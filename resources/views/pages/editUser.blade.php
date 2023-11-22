@extends('layouts.app')

@section('title', 'Profile')


@section('content')
<section id="profileEdit">

  <div>
    <h2>Edit Your Profile</h2>
    <form action="{{ route('update_user')}}" method="POST">
            {{ csrf_field() }}
            <input id="name" type="text" name="name" placeholder="{{ $user->name }}">
            <input id="username" type="text" name="username" placeholder="{{ $user->username }}">
            <input id="email" type="email" name="email" placeholder="{{ $user->email }}">
            <input id="password" type="password" name="password" placeholder="Password">
            <button type="submit">
                Edit Profile
            </button>
        </form>

  </div>

</section>
@endsection

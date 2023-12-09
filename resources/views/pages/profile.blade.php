@extends('layouts.app')

@section('title', 'Profile')


@section('content')
<section id="profile">

    <h2 id="title_display">
        <div>
           Profile
        </div>
    </h2>

  </div>
  <div id="info">
    <p>Name: {{ $user->name }}</p><br>
    <p>Username: {{ $user->username }}</p><br>
    <p>email: {{ $user->email }}</p><br>

  </div>

  <div id="profilePic">
  <img src="/images/profile/{{ $user->picture }}" alt="Profile picture" width="240" height="240">
</div>

  <a class="button" href="{{ url('/edit_user') }}"> Edit Profile </a>
  <a class="button" href="{{ url('/edit_profile_picture') }}"> Change Picture </a>

  @if (Auth::user()->is_admin)
  <a class="button" href="{{ url('/users') }}"> Administration Page </a>

  @endif



</section>
@endsection

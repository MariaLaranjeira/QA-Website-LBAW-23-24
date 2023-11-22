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

  <a class="button" href="{{ url('/edit_user') }}"> Edit Profile </a>

  @if (Auth::user()->is_admin)
  <a class="button" href="{{ url('/users') }}"> Administration Page </a>

  @endif



</section>
@endsection

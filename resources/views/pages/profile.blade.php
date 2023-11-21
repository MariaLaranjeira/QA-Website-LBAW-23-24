@extends('layouts.app')

@section('title', 'Profile')


@section('content')
<section id="profile">

    <h2 id="title_display">
        <div>
           User Profile
        </div>
    </h2>

  </div>
  <div class="d-flex justify-content-center">
  <div class="card" style="width: 18rem;">
  <div id="info">
    <p>Name: {{ $user->name }}</p><br>
    <p>Username: {{ $user->username }}</p><br>
    <p>email: {{ $user->email }}</p><br>

  </div>

</section>
@endsection

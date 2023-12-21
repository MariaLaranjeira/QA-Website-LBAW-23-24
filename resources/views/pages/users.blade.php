@extends('layouts.app')

@section('title', 'Users')

3

@section('content')
  <section id="users_list">
      @each('partials.user', $users, 'user')
  </section>
@endsection


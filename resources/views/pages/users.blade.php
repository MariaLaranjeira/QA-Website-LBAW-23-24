@extends('layouts.app')

@section('title', 'Users')



@section('content')
  <section id="users_list">
      @each('partials.user', $users, 'user')
  </section>
@endsection


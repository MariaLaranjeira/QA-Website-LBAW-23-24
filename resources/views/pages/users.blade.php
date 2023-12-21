@extends('layouts.app')

@section('title', 'Users')

@section('scripts')
  <script src="{{ asset('js/deleteAccount.js') }}" defer></script>
@endsection

@section('content')
  <section id="users_list">
      @each('partials.user', $users, 'user')
  </section>
@endsection


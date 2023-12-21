@extends('layouts.app')

@section('title', 'Profile')

@section('styles')
<link href="{{ url('css/profile.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ url('js/deleteAccount.js') }}" defer></script>
@endsection

@section('content')
<section id="profile">

    <h2 id="title_display">
        <div>
            Profile
        </div>
    </h2>

    <div id="info">
        <p>Name: {{ $user->name }}</p><br>
        <p>Username: {{ $user->username }}</p><br>
        @auth
        @if (Auth::user()->getAuthIdentifier() == $user->user_id)
        <p>email: {{ $user->email }}</p><br>
        @endif
        @endauth
    </div>

    <div id="profilePic">
        <img src="/images/profile/{{ $user->picture }}" alt="Profile picture" width="240" height="240">
    </div>

    @auth
    @if (Auth::user()->getAuthIdentifier() == $user->user_id)
    <a class="button" href="{{ url('/edit_user') }}"> Edit Profile </a>
    <a class="button" href="{{ url('/edit_profile_picture') }}"> Change Picture </a>
    <form action="{{ route('delete_account')}}" method="POST">
    {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{ $user->user_id}}">
        <button type="submit" id="delete_account_button">
            Delete This Profile
        </button>
    </form>
    @endif
    @if (\App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists() && Auth::user()->getAuthIdentifier() == $user->user_id)
    <a class="button" href="{{ url('/users') }}"> Administration Page </a>
    <a class="button" href="{{ url('/tags') }}"> Tag Management </a>
    @endif
    @endauth





</section>
@endsection

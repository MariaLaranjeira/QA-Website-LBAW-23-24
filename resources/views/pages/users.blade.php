@extends('layouts.app')

@section('title', 'Users')

@section('scripts')
    <script src="{{ asset('js/deleteAccount.js') }}" defer></script>
@endsection

@section('content')
<section id="search_users">
    <form method="GET" action="{{ route('search_users') }}">
        @isset($search_user)
        <input type="text" name="search" id="search" value="{{ $search_user }}" placeholder="Search user..">
        @endisset
        @empty($search_user)
        <input type="text" name="search" id="search" placeholder="Search user..">
        @endempty
    </form>
</section>
<section id="users_list">
    @forelse($users as $user)
        @include('partials.user', ['user' => $user])
    @empty
        <h2 class="no_results">No results found</h2>
    @endforelse
</section>
@endsection


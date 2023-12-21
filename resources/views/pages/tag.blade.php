@extends('layouts.app')

@section('title', $tag->name)

@section('sytles')
@endsection

@section('scripts')
@endsection

@section('content')

    <h2>{{ $tag->name }}</h2>
    <section id="tag_info">
        <div>There are {{ \App\Models\UserTagFollow::query()->where('id_tag', $tag->name)->count() }} users who follow this Tag</div>
        @auth
            @if (\App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists())
            <div class="button" id="edit_tag">Edit</div>
            <div class="button" id="delete_tag">Delete</div>
            @endif
            <div class="button" id="follow_tag">Follow</div>
        @endauth
    </section>

    <h2>Questions tagged</h2>
    @each('partials.question', $tag->questions, 'question')

@endsection

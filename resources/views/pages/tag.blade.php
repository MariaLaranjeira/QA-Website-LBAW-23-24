@extends('layouts.app')

@section('title', $tag->name)

@section('sytles')
@endsection

@section('scripts')
<script> window.tagName = "{{ $tag->name }}"</script>
<script type="text/javascript" src={{ url('js/tagPage.js') }} defer> </script>
@endsection

@section('content')
    <section id="tag_info">
        <h2>{{ $tag->name }}</h2>
        <div>There are </div>
        <div id="follow_count">{{ \App\Models\UserTagFollow::query()->where('id_tag', $tag->name)->count() }}</div>
        <div> users who follow this Tag</div>
        @auth
            @if (\App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists())
            <div class="button" id="edit_tag">Edit</div>
            <div class="button" id="delete_tag">Delete</div>
            @endif
            @if (\App\Models\UserTagFollow::where('id_user', Auth::user()->getAuthIdentifier())->where('id_tag', $tag->name)->exists())
            <div class="button" id="follow_tag">Unfollow</div>
            @else
            <div class="button" id="follow_tag">Follow</div>
            @endif
        @endauth
    </section>

    @auth
    @if (\App\Models\UserTagFollow::where('id_user', Auth::user()->getAuthIdentifier())->where('id_tag', $tag->name)->exists())
    <section id="edit_tag_section" style="display: none">
        <form action="{{ route('editTag', ['name' => $tag->name]) }}" method="POST">
            @csrf
            <input type="text" name="name" id="tag_name_edit" value="{{ $tag->name }}">
            <button type="reset" id="cancelButton" data-name="{{ $tag->name }}">
                Cancel
            </button>
            <button type="submit" id="applyButton">
                Apply
            </button>
        </form>
    </section>
    @endif
    @endauth

    <h2>Questions tagged</h2>
    @each('partials.question', $tag->questions, 'question')

@endsection

@extends('layouts.app')

@section('title', 'Tags')

@section('scripts')
<script type="text/javascript" src={{ url('js/manageTags.js') }} defer> </script>
@endsection

@section('content')

    <section id="search_tags">
        <form method="GET" action="{{ route('search_tags') }}">
            @isset($search_tags)
            <input type="text" name="search" id="search" value="{{ $search_tags }}" placeholder="Search tags..">
            @endisset
            @empty($search_tags)
            <input type="text" name="search" id="search" placeholder="Search tags..">
            @endempty
        </form>
    </section>
    <section id="tags_list">
        @each('partials.editTags', $tags, 'tag')
    </section>

    @auth
        @if (\App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists())
            <button id="new_tag_button">Add new Tag</button>

            <section id="new_tag" style="display: none">
                <form action="{{ route('createTag') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" name="name" id="new_tag_name" placeholder="New Tag Name">
                    <button type="reset" id="cancel_new_tag_button">Cancel</button>
                    <button type="submit" id="new_tag_button">Add new Tag</button>
                </form>
            </section>
        @endif
    @endauth
@endsection

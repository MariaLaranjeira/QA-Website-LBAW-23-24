@extends('layouts.app')

@section('title', 'Tags')

@section('scripts')
<script type="text/javascript" src={{ url('js/manageTags.js') }} defer> </script>
@endsection

@section('content')
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

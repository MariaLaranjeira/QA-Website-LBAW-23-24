@extends('layouts.app')

@section('title', 'Tags')

@section('scripts')
<script type="text/javascript" src={{ url('js/manageTags.js') }} defer> </script>
@endsection

@section('content')
    <section id="tags_list">
        @each('partials.editTags', $tags, 'tag')
    </section>


    <button class="new_tag_button" onclick="">Add new Tag</button>
@endsection

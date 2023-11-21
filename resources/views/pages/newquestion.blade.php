@extends('layouts.app')

@section('title', 'New Question')

@section('content')

<section id = "new_question">
    <form class="new_question">
        <input type="text" name="title" placeholder="Title">
        <input type="text" name="text_body" placeholder="Text Body">
        <button type="submit" class="new_question">
            Post a Question
        </button>
    </form>

@endsection
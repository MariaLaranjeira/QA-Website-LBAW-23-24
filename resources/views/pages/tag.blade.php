@extends('layouts.app')

@section('title', $tag->name)

@section('sytles')
@endsection

@section('scripts')
@endsection

@section('content')

    <h2>{{ $tag->name }}</h2>
    <section id=""

    <h2>Questions tagged</h2>
    @each('partials.question', $tag->questions, 'question')

@endsection

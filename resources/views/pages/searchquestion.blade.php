@extends('layouts.app')

@section('title', 'Search')

@section('styles')
<link href="{{ url('css/question.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h2>Results the search </h2>
    @forelse($questions as $question)
            @include('partials.question', ['question' => $question])
        @empty
            <h2 class="no_results">No results found</h2>
    @endforelse

@endsection
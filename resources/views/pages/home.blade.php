@extends('layouts.app')

@section('title', 'CreativeHub Home')

@section('styles')
<link href="{{ url('css/question.css') }}" rel="stylesheet">
@endsection

@section('content')
<h3>{{ session('status') }}</h3>
     <h4>{{ session('message') }}</h4>
     @if(session('details'))
         @foreach(session('details') as $detail)
             <h5>{{ $detail }}</h5>
         @endforeach
     @endif

<section id="home">
    @auth
        <form action="{{ route('newquestion') }}">
            <button type="submit">

                Post New Question

            </button>
        </form>
    @endauth
    <h2>Recent Questions</h2>

    @each('partials.question', $questions, 'question')
</section>

@endsection

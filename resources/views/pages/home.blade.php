@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section id="home">
    <form method="GET" action="{{ route('newquestion') }}">
        <button type="submit">

            Post New Question

        </button>
    </form>
</section>

@endsection
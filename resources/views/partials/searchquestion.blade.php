@forelse($questions as $question)
    @include('partials.question', ['question' => $question])
@empty
    <h2 class="no_results">No results found</h2>
@endforelse


<!--option value="{{ $tag->name }}">{{ $tag->name }}</option-->

<label for="{{ $tag->name }}">
    <input type="checkbox" name="tags[]" id="{{ $tag->name }}" value="{{ $tag->name }}">
    {{ $tag->name }}
</label>

<section id="view{{ $tag->name }}Mode">
    <label for="{{ $tag->name }}">
        {{ $tag->name }}
        <button class="edit_tag_button" onclick="editExistingTag('{{ $tag->name }}')">Edit</button>
        <form action="{{ route('deleteTag', ['name' => $tag->name]) }}" method="POST">
            {{ csrf_field() }}
            <button class="delete_tag_button">Delete</button>
        </form>
    </label>
</section>

<section id="edit{{ $tag->name }}Mode" style="display: none">
    <form action="{{ route('editTag', ['name' => $tag->name]) }}" method="POST">
        @csrf
        <input type="text" name="name" id="tag_name_edit" value="{{ $tag->name }}">
        <button type="reset" id="cancelButton" onclick="cancelEditExistingTag('{{ $tag->name }}')">
            Cancel
        </button>
        <button type="submit" id="applyButton">
            Apply
        </button>
    </form>
</section>

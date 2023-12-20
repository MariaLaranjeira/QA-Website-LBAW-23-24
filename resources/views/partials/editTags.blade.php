<section id="view{{ $tag->name }}Mode">
    <label for="{{ $tag->name }}">
        {{ $tag->name }}
        <button class="edit_tag_button" onclick="editExistingTag({{ $tag->name }})">Edit</button>
        <button class="delete_tag_button" onclick="">Delete</button>
    </label>
</section>

<section id="editTagMode" style="display: none">
    <form action="{{ route('editTag', ['name' => $tag->name]) }}" method="POST">
        @csrf
        <input type="text" name="name" id="tag_name_edit" value="{{ $tag->name }}">
        <button type="reset" id="cancelButton">
            Cancel
        </button>
        <button type="submit" id="applyButton">
            Apply
        </button>
    </form>
</section>

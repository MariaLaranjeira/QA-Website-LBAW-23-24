<div id="commentA_view_{{ $commentA->comment_id }}">
    <article class="comment" data-commentA-id="{{ $commentA->comment_id }}">
        @auth
        @if (Auth::user()->getAuthIdentifier() == $commentA->id_user || \App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists() || \App\Models\Moderator::where('mod_id', Auth::user()->getAuthIdentifier())->exists())
        <form action ="{{ route('deletecomment', ['id' => $commentA->comment_id]) }}" method = "POST">
            {{ csrf_field() }}
            <button type="submit" class="delete_commentA">&#10761;</button>
        </form>

        <button type="submit" class="edit_commentA" data-commentA-id="{{ $commentA->comment_id }}">&#9998;</button>
        @endif
        @endauth
        <header>
            <h4> {{ $commentA->text_body }} </h4>
        </header>
    </article>
</div>

<section class="commentA-edit-mode" id="commentA_edit_{{ $commentA->comment_id }}" style="display: none;">

    <form method = "POST" action = "{{ route('editingcomment', ['id' => $commentA->comment_id]) }}" >
        {{ csrf_field() }}

        <h2 id="commentA_edit_text_body">
            <input type="text" name="commentQ_body" id="commentA_text_body_edit" value="{{ $commentA->text_body }}"></input>
            @if ($errors->has('commentQ_body'))
            <span class="error">
                    Your text body must be between 5 and 4000 characters long.
            </span>
            <br>
            @endif
        </h2>
        <button type="reset" class="cancelCommentAButton" data-commentA-id="{{ $commentA->comment_id }}">
            Cancel
        </button>
        <button type="submit" class="applyCommentAButton" data-commentA-id="{{ $commentA->comment_id }}">
            Apply
        </button>
    </form>
</section>
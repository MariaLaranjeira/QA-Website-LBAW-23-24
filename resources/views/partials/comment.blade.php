<div id="commentQ_view_{{ $commentQ->comment_id }}">
    <article class="comment" data-comment-id="{{ $commentQ->comment_id }}">
        @auth
        @if (Auth::user()->getAuthIdentifier() == $commentQ->id_user || \App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists() || \App\Models\Moderator::where('mod_id', Auth::user()->getAuthIdentifier())->exists())
        <form action ="{{ route('deletecomment', ['id' => $commentQ->comment_id]) }}" method = "POST">
            {{ csrf_field() }}
            <button type="submit" class="delete_commentQ">&#10761;</button>
        </form>

        <button type="submit" class="edit_commentQ" data-comment-id="{{ $commentQ->comment_id }}">&#9998;</button>
        @endif
        @endauth
        <header>
            <h4>{{ $commentQ->text_body }}</h4>
        </header>
    </article>
</div>
<section class="commentQ-edit-mode" id="commentQ_edit_{{ $commentQ->comment_id }}" style="display: none;">

    <form method = "POST" action = "{{ route('editingcomment', ['id' => $commentQ->comment_id]) }}" >
        {{ csrf_field() }}

        <h2 id="commentQ_edit_text_body">
            <input type="text" name="commentQ_body" id="commentQ_text_body_edit" value="{{ $commentQ->text_body }}"></input>
            @if ($errors->has('commentQ_body'))
            <span class="error">
                    Your text body must be between 5 and 4000 characters long.
            </span>
            <br>
            @endif
        </h2>
        <button type="reset" class="cancelCommentQButton" data-comment-id="{{ $commentQ->comment_id }}">
            Cancel
        </button>
        <button type="submit" class="applyCommentQButton" data-comment-id="{{ $commentQ->comment_id }}">
            Apply
        </button>
    </form>
</section>
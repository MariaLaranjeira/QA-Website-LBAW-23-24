<article class="user" data-id="{{ $user->user_id }}">

    <div id="info">
        <a href="/profile/{{ $user->user_id }}">Name: {{ $user->name }}</a><br>
        <a href="/profile/{{ $user->user_id }}">Username: {{ $user->username }}</a><br>
        @auth
        @if (Auth::user()->getAuthIdentifier() == $user->user_id || \App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists())
        <a href="/profile/{{ $user->user_id }}">email: {{ $user->email }}</a><br>
        @endif
        @if (\App\Models\Admin::where('admin_id', Auth::user()->getAuthIdentifier())->exists())
        <div>
            <form action="{{ route('delete_profile')}}" method="POST">
            {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ $user->user_id}}">
                <button type="submit" class="delete_profile_button">
                    Delete This Profile
                </button>
            </form>
            @if ($user->is_blocked == 0)
            <button class="block_user">
                Block This User
            </button>
            @else
            <button class="block_user">
                Unblock This User
            </button>
            @endif
        </div>
        @endif
        @endauth
    </div>
    <hr>

</article>
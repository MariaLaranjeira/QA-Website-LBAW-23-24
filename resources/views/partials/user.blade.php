<article class="user" data-id="{{ $user->id }}">

  <div id="info">
    <p>Name: {{ $user->name }}</p><br>
    <p>Username: {{ $user->username }}</p><br>
    <p>email: {{ $user->email }}</p><br>

    <div>
    <form action="{{ route('delete_profile')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{ $user->user_id}}">
            <button type="submit" class="delete_profile_button">
                Delete This Profile
            </button>
        </form>

  </div>
    
  </div>

  <hr>

</article>
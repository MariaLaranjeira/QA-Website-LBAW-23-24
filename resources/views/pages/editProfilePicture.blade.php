@extends('layouts.app')

@section('title', 'Profile')


@section('content')
<section id="profilePictureEdit">

  <div>
    <h2>Change Your Profile Picture</h2>
    <form action="{{ route('upload_picture')}}" id="edit_profile_picture" class="edit_profile_picture" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            <label for="avatar">Choose a profile picture:</label>

            <input type="file" id="avatar" name="avatar">

            <button type="submit">
                Save
            </button>
        </form>

  </div>

</section>
@endsection

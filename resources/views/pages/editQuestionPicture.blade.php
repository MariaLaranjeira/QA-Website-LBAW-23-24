@extends('layouts.app')

@section('title', 'Question')


@section('content')
<section id="QuestionPictureEdit">

  <div>
    <h2>Change Your Profile Picture </h2>
    <form action="{{ route('upload_question_picture', ['id' => $question->question_id]) }}" id="edit_question_picture" class="edit_question_picture" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            <label for="avatar">Choose picture to upload:</label>

            <input type="file" id="questionPic" name="questionPic">

            <button type="submit">
                Save
            </button>
        </form>

  </div>

</section>
@endsection

document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll('.delete');
    const editButton = document.getElementById('question_edit_button');
    const viewModeSection = document.getElementById('question');
    const editModeSection = document.getElementById('editMode');
    const applyButton = document.getElementById('applyButton');
    const cancelButton = document.getElementById('cancelButton');
    const answerButton = document.getElementById('postAnswer');
    const commentButton = document.getElementById('postComment');

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Show a confirmation dialog
            const confirmation = confirm('Are you sure you want to delete this question?');
            if (confirmation) {
                const deleteForm = button.closest('form');
                const url = deleteForm.getAttribute('action');
                const method = deleteForm.getAttribute('method');

                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Handle the success response, e.g., redirect or update the UI
                        window.location.replace('/home'); // Redirect to the home page, replacing the current history entry
                    } else {
                        // Handle the error, e.g., display an error message
                        console.error('Error:', xhr.statusText);
                    }
                };

                xhr.onerror = function () {
                    // Handle the error, e.g., display an error message
                    console.error('Network error occurred');
                };

                xhr.send(new FormData(deleteForm));
            }
        });
    });

    if (editButton && viewModeSection && editModeSection && applyButton && cancelButton) {
        editButton.addEventListener('click', function () {
            const titleInput = document.getElementById('question_title');
            const textBodyInput = document.getElementById('text_body_display');

            // Assuming you have elements for the editing form in the HTML
            const editTitleInput = document.getElementById('question_title_edit');
            const editTextBodyInput = document.getElementById('question_text_body_edit');

            editTitleInput.value = titleInput.textContent.trim();
            editTextBodyInput.value = textBodyInput.textContent.trim();
            // Switch from view mode to edit mode
            viewModeSection.style.display = 'none';
            editModeSection.style.display = 'block';
        });

        applyButton.addEventListener('click', function (e) {
            e.preventDefault();

            const updateQuestionConfirmation = confirm('Are you sure you want to update this question?');
            if (updateQuestionConfirmation) {
                const updateForm = applyButton.closest('form');
                const url = updateForm.getAttribute('action');
                const method = updateForm.getAttribute('method');

                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const response = xhr.responseText;

                        try {
                            const jsonResponse = JSON.parse(response);

                            // Handle the success JSON response, e.g., redirect or update the UI
                            window.location.reload();
                        } catch (jsonParseError) {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(response, 'text/html');
                            const editTitleField = document.getElementById('edit_title_display');
                            const titleField = doc.getElementById('edit_title_display')
                            editTitleField.innerHTML = titleField.innerHTML;
                            const editTextField = document.getElementById('edit_text_body');
                            const textField = doc.getElementById('edit_text_body')
                            editTextField.innerHTML = textField.innerHTML;
                        }
                    } else {
                        // Handle the error, e.g., display an error message
                        console.error('Error:', xhr.statusText);
                    }
                };

                xhr.onerror = function () {
                    // Handle the error, e.g., display an error message
                    console.error('Network error occurred');
                };

                xhr.send(new FormData(updateForm));
            }


        });

        cancelButton.addEventListener('click', function () {
            viewModeSection.style.display = 'block';
            editModeSection.style.display = 'none';
        });
    }

    if (answerButton) {
        answerButton.addEventListener('click', function (e) {
            e.preventDefault();

            const answerForm = answerButton.closest('form');
            const url = answerForm.getAttribute('action');
            const method = answerForm.getAttribute('method');

            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = xhr.responseText;

                    try {
                        const jsonResponse = JSON.parse(response);

                        // Handle the success JSON response, e.g., redirect or update the UI
                        window.location.reload();
                    } catch (jsonParseError) {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(response, 'text/html');
                        const answerField = document.getElementById('post_answer_error');
                        const newAnswerField = doc.getElementById('post_answer_error');
                        answerField.innerHTML = newAnswerField.innerHTML;
                        console.log("did it do it?");
                        console.log(answerField.innerHTML);
                    }
                } else {
                    // Handle the error, e.g., display an error message
                    console.error('Error:', xhr.statusText);
                }
            };

            xhr.onerror = function () {
                // Handle the error, e.g., display an error message
                console.error('Network error occurred');
            };

            xhr.send(new FormData(answerForm));

        });
    }
    if(commentButton){
        commentButton.addEventListener('click', function (e) {
            e.preventDefault();

            const commentForm = commentButton.closest('form');
            const url = commentForm.getAttribute('action');
            const method = commentForm.getAttribute('method');

            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = xhr.responseText;
                    console.log(response);

                    try {
                        const jsonResponse = JSON.parse(response);

                        // Handle the success JSON response, e.g., redirect or update the UI
                        window.location.reload();
                    } catch (jsonParseError) {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(response, 'text/html');
                        const commentField = document.getElementById('post_comment_error');
                        const newCommentField = doc.getElementById('post_comment_error');
                        commentField.innerHTML = newCommentField.innerHTML;
                        console.log("did it do it?");
                        console.log(commentField.innerHTML);
                    }
                } else {
                    // Handle the error, e.g., display an error message
                    console.error('Error:', xhr.statusText);
                }
            };

            xhr.onerror = function () {
                // Handle the error, e.g., display an error message
                console.error('Network error occurred');
            };

            xhr.send(new FormData(commentForm));

        });
    }
});

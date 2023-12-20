document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll('.delete');
    const questionEditButton = document.getElementById('question_edit_button');
    const answerEditButtons = document.querySelectorAll('.answer_edit_button');
    const questionViewModeSection = document.getElementById('question');
    const questionEditModeSection = document.getElementById('editMode');
    const questionApplyButton = document.getElementById('applyButton');
    const questionCancelButton = document.getElementById('cancelButton');
    const answerApplyButtons = document.querySelectorAll('.applyAnswerButton');
    const answerCancelButtons = document.querySelectorAll('.cancelAnswerButton');
    const answerButton = document.getElementById('postAnswer');
    const upVoteButton = document.getElementById('upVoteButton');
    const downVoteButton = document.getElementById('downVoteButton');
    const answerUpVoteButtons = document.querySelectorAll('.answer_upvote');
    const answerDownVoteButtons = document.querySelectorAll('.answer_downvote');
    const answerDeleteButtons = document.querySelectorAll('.answer_delete');
    const commentQButton = document.getElementById('postCommentQ');
    const commentAButtons = document.querySelectorAll('.post-comment-btn');

    const commentQEditButtons = document.querySelectorAll('.edit_commentQ');
    const commentQApplyButtons = document.querySelectorAll('.applyCommentQButton');
    const commentQCancelButtons = document.querySelectorAll('.cancelCommentQButton');

    const commentQDeleteButtons = document.querySelectorAll('.delete_commentQ');



    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


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

    commentQDeleteButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Show a confirmation dialog
            const confirmation = confirm('Are you sure you want to delete this comment?');
            if (confirmation) {
                const deleteForm = button.closest('form');
                const url = deleteForm.getAttribute('action');
                const method = deleteForm.getAttribute('method');

                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Handle the success response, e.g., redirect or update the UI
                        window.location.reload();
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

    answerDeleteButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Show a confirmation dialog
            const confirmation = confirm('Are you sure you want to delete this answer?');
            if (confirmation) {
                const deleteForm = button.closest('form');
                const url = deleteForm.getAttribute('action');
                const method = deleteForm.getAttribute('method');

                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Handle the success response, e.g., redirect or update the UI
                        window.location.reload();
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

    commentQEditButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const commentId = e.currentTarget.getAttribute('data-comment-id');
            document.getElementById(`commentQ_view_${commentId}`).style.display = 'none';
            document.getElementById(`commentQ_edit_${commentId}`).style.display = 'block';
        });
    });

    commentQApplyButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const updateCommentConfirmation = confirm('Are you sure you want to update this comment?');
            if (updateCommentConfirmation) {
                const updateForm = button.closest('form');
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
                            console.log("am i here?");
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(response, 'text/html');
                            const editTextField = document.getElementById('commentQ_edit_text_body');
                            const textField = doc.getElementById('commentQ_edit_text_body')
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
    });

    commentQCancelButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const commentId = e.currentTarget.getAttribute('data-comment-id');
            console.log(commentId);
            document.getElementById(`commentQ_view_${commentId}`).style.display = 'block';
            document.getElementById(`commentQ_edit_${commentId}`).style.display = 'none';
        });
    });

    answerEditButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const answerId = e.currentTarget.getAttribute('data-answer-id');
            console.log(answerId);
            document.getElementById(`answer_view_${answerId}`).style.display = 'none';
            document.getElementById(`answer_edit_${answerId}`).style.display = 'block';
        });
    });

    answerApplyButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const updateAnswerConfirmation = confirm('Are you sure you want to update this answer?');
            if (updateAnswerConfirmation) {
                const updateForm = button.closest('form');
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
                            console.log("am i here?");
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(response, 'text/html');
                            const editTextField = document.getElementById('answer_edit_text_body');
                            const textField = doc.getElementById('answer_edit_text_body')
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
    });

    answerCancelButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const answerId = e.currentTarget.getAttribute('data-answer-id');
            document.getElementById(`answer_view_${answerId}`).style.display = 'block';
            document.getElementById(`answer_edit_${answerId}`).style.display = 'none';
        });
    });

    if (questionEditButton && questionViewModeSection && questionEditModeSection && questionApplyButton && questionCancelButton) {
        questionEditButton.addEventListener('click', function () {
            const titleInput = document.getElementById('question_title');
            const textBodyInput = document.getElementById('text_body_display');

            // Assuming you have elements for the editing form in the HTML
            const editTitleInput = document.getElementById('question_title_edit');
            const editTextBodyInput = document.getElementById('question_text_body_edit');

            editTitleInput.value = titleInput.textContent.trim();
            editTextBodyInput.value = textBodyInput.textContent.trim();
            // Switch from view mode to edit mode
            questionViewModeSection.style.display = 'none';
            questionEditModeSection.style.display = 'block';
        });

        questionApplyButton.addEventListener('click', function (e) {
            e.preventDefault();

            const updateQuestionConfirmation = confirm('Are you sure you want to update this question?');
            if (updateQuestionConfirmation) {
                const updateForm = questionApplyButton.closest('form');
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

        questionCancelButton.addEventListener('click', function () {
            questionViewModeSection.style.display = 'block';
            questionEditModeSection.style.display = 'none';
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
                        window.location.reload();
                    } catch (jsonParseError) {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(response, 'text/html');
                        const answerField = document.getElementById('post_answer_error');
                        const newAnswerField = doc.getElementById('post_answer_error');
                        answerField.innerHTML = newAnswerField.innerHTML;
                        console.log(answerField.innerHTML);
                    }
                } else {
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

    if (upVoteButton && downVoteButton) {
        upVoteButton.addEventListener('click', function () {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/question/' + window.questionID + '/upvote', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.send();
            xhr.onload = function () {
                const previous = window.document.getElementById('rating').innerHTML
                let newRating;
                switch (xhr.status) {
                    case 200:
                        newRating = parseInt(previous) + 1;
                        break;
                    case 202:
                        newRating = parseInt(previous) - 1;
                        break;
                    case 204:
                        newRating = parseInt(previous) + 2;
                        break;
                    default:
                        console.error('Error:', xhr.statusText);
                        newRating = parseInt(previous);
                        break;
                }
                window.document.getElementById('rating').innerHTML = newRating.toString();
            };
        });

        downVoteButton.addEventListener('click', function () {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/question/' + window.questionID + '/downvote', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.send();
            xhr.onload = function () {
                const previous = window.document.getElementById('rating').innerHTML
                let newRating;
                switch (xhr.status) {
                    case 201:
                        newRating = parseInt(previous) - 1;
                        break;
                    case 203:
                        newRating = parseInt(previous) - 2;
                        break;
                    case 205:
                        newRating = parseInt(previous) + 1;
                        break;
                    default:
                        console.error('Error:', xhr.statusText);
                        newRating = parseInt(previous);
                        break;
                }
                window.document.getElementById('rating').innerHTML = newRating.toString();
            };
        });
    }

    answerUpVoteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            console.log('upvote');
            const xhr = new XMLHttpRequest();
            const voteSection = this.closest('.vote');
            const span = voteSection.querySelector('span#rating');
            const id = span.dataset.id;
            xhr.open('POST', '/answer/' + id + '/upvote', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.send();
            xhr.onload = function () {
                const previous = span.innerHTML;
                let newRating;
                switch (xhr.status) {
                    case 200:
                        newRating = parseInt(previous) + 1;
                        break;
                    case 202:
                        newRating = parseInt(previous) - 1;
                        break;
                    case 204:
                        newRating = parseInt(previous) + 2;
                        break;
                    default:
                        console.error('Error:', xhr.statusText);
                        newRating = parseInt(previous);
                        break;
                }
                span.innerHTML = newRating.toString();
            };
        });
    });

    answerDownVoteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const xhr = new XMLHttpRequest();
            const voteSection = this.closest('.vote');
            const span = voteSection.querySelector('span#rating');
            const id = span.dataset.id;
            xhr.open('POST', '/answer/' + id + '/downvote', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.send();
            xhr.onload = function () {
                const previous = span.innerHTML;
                let newRating;
                switch (xhr.status) {
                    case 201:
                        newRating = parseInt(previous) - 1;
                        break;
                    case 203:
                        newRating = parseInt(previous) - 2;
                        break;
                    case 205:
                        newRating = parseInt(previous) + 1;
                        break;
                    default:
                        console.error('Error:', xhr.statusText);
                        newRating = parseInt(previous);
                        break;
                }
                span.innerHTML = newRating.toString();
            }
        });
    });
    if(commentQButton){
        commentQButton.addEventListener('click', function (e) {
            e.preventDefault();

            const commentForm = commentQButton.closest('form');
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
    commentAButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const commentForm = button.closest('form');
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
    });
});

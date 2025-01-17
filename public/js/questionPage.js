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
    const followQuestionButton = document.getElementById('followQuestion');

    const commentQEditButtons = document.querySelectorAll('.edit_commentQ');
    const commentQApplyButtons = document.querySelectorAll('.applyCommentQButton');
    const commentQCancelButtons = document.querySelectorAll('.cancelCommentQButton');
    const commentQDeleteButtons = document.querySelectorAll('.delete_commentQ');

    const commentAEditButtons = document.querySelectorAll('.edit_commentA');
    const commentAApplyButtons = document.querySelectorAll('.applyCommentAButton');
    const commentACancelButtons = document.querySelectorAll('.cancelCommentAButton');
    const commentADeleteButtons = document.querySelectorAll('.delete_commentA');


    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (followQuestionButton) {
        followQuestionButton.addEventListener('click', function (e) {
            sendAjaxRequest('POST', '/question/' + window.questionID + '/follow', null, function () {
                switch (this.status) {
                    case 200:
                        followQuestionButton.innerHTML = 'Unfollow';
                        break;
                    case 201:
                        followQuestionButton.innerHTML = 'Follow';
                        break;
                    case 403:
                        alert("You cannot perform this action!");
                        break;
                    default:
                        console.error('Error:', this.statusText);
                        break;
                }
            });
        });
    }

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
                    }
                    else if (xhr.status === 403) {
                        alert("You cannot perform this action!");
                    }
                    else {
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
                    }
                    else if (xhr.status === 403) {
                        alert("You cannot perform this action!");
                    }
                    else {
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

    commentADeleteButtons.forEach(function (button) {
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
                    }
                    else if (xhr.status === 403) {
                        alert("You cannot perform this action!");
                    }
                    else {
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
                    }
                    else if (xhr.status === 403) {
                        alert("You cannot perform this action!");
                    }
                    else {
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
                            window.location.reload();
                        } catch (jsonParseError) {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(response, 'text/html');
                            const editTextField = document.getElementById('commentQ_edit_text_body');
                            const textField = doc.getElementById('commentQ_edit_text_body')
                            editTextField.innerHTML = textField.innerHTML;
                        }
                    }
                    else if (xhr.status === 403) {
                        alert("You cannot perform this action!");
                    }
                    else {
                        console.error('Error:', xhr.statusText);
                    }
                };
                xhr.onerror = function () {
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

    commentAEditButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const commentId = e.currentTarget.getAttribute('data-commentA-id');
            document.getElementById(`commentA_view_${commentId}`).style.display = 'none';
            document.getElementById(`commentA_edit_${commentId}`).style.display = 'block';
        });
    });

    commentAApplyButtons.forEach(function(button) {
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
                            window.location.reload();
                        } catch (jsonParseError) {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(response, 'text/html');
                            const editTextField = document.getElementById('commentA_edit_text_body');
                            const textField = doc.getElementById('commentA_edit_text_body')
                            editTextField.innerHTML = textField.innerHTML;
                        }
                    }
                    else if (xhr.status === 403) {
                        alert("You cannot perform this action!");
                    }
                    else {
                        console.error('Error:', xhr.statusText);
                    }
                };
                xhr.onerror = function () {
                    console.error('Network error occurred');
                };
                xhr.send(new FormData(updateForm));
            }
        });
    });

    commentACancelButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const commentId = e.currentTarget.getAttribute('data-commentA-id');
            console.log(commentId);
            document.getElementById(`commentA_view_${commentId}`).style.display = 'block';
            document.getElementById(`commentA_edit_${commentId}`).style.display = 'none';
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
                            window.location.reload();
                        } catch (jsonParseError) {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(response, 'text/html');
                            const editTextField = document.getElementById('answer_edit_text_body');
                            const textField = doc.getElementById('answer_edit_text_body')
                            editTextField.innerHTML = textField.innerHTML;
                        }
                    }
                    else if (xhr.status === 403) {
                        alert("You cannot perform this action!");

                    } else {
                        console.error('Error:', xhr.statusText);
                    }
                }
                xhr.onerror = function () {
                    console.error('Network error occurred');
                }
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
                    }
                    else if (xhr.status === 403) {
                        alert("You cannot perform this action!");
                    }
                    else {
                        console.error('Error:', xhr.statusText);
                    }
                };
                xhr.onerror = function () {
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
                }
                else if (xhr.status === 403) {
                    alert("You cannot perform this action!");
                }
                else {
                    console.error('Error:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error('Network error occurred');
            };
            xhr.send(new FormData(answerForm));
        });
    }

    if (upVoteButton && downVoteButton) {
        upVoteButton.addEventListener('click', function () {
            sendAjaxRequest('POST', '/question/' + window.questionID + '/upvote', null, function () {
                const previous = window.document.getElementById('rating').innerHTML
                let newRating;
                switch (this.status) {
                    case 200:
                        newRating = parseInt(previous) + 1;
                        break;
                    case 202:
                        newRating = parseInt(previous) - 1;
                        break;
                    case 204:
                        newRating = parseInt(previous) + 2;
                        break;
                    case 403:
                        alert("You cannot perform this action!");
                        break;
                    default:
                        console.error('Error:', this.statusText);
                        newRating = parseInt(previous);
                        break;
                }
                window.document.getElementById('rating').innerHTML = newRating.toString();
            });
        });

        downVoteButton.addEventListener('click', function () {
            sendAjaxRequest('POST', '/question/' + window.questionID + '/downvote', null, function () {
                const previous = window.document.getElementById('rating').innerHTML
                let newRating;
                switch (this.status) {
                    case 201:
                        newRating = parseInt(previous) - 1;
                        break;
                    case 203:
                        newRating = parseInt(previous) - 2;
                        break;
                    case 205:
                        newRating = parseInt(previous) + 1;
                        break;
                    case 403:
                        alert("You cannot perform this action!");
                        break;
                    default:
                        console.error('Error:', this.statusText);
                        newRating = parseInt(previous);
                        break;
                }
                window.document.getElementById('rating').innerHTML = newRating.toString();
            });
        });
    }

    answerUpVoteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            console.log('upvote');
            const voteSection = this.closest('.vote');
            const span = voteSection.querySelector('span#rating');
            const id = span.dataset.id;
            sendAjaxRequest('POST', '/answer/' + id + '/upvote', null, function () {
                const previous = span.innerHTML;
                let newRating;
                switch (this.status) {
                    case 200:
                        newRating = parseInt(previous) + 1;
                        break;
                    case 202:
                        newRating = parseInt(previous) - 1;
                        break;
                    case 204:
                        newRating = parseInt(previous) + 2;
                        break;
                    case 403:
                        alert("You cannot perform this action!");
                        break;
                    default:
                        console.error('Error:', this.statusText);
                        newRating = parseInt(previous);
                        break;
                }
                span.innerHTML = newRating.toString();
            });
        });
    });

    answerDownVoteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const voteSection = this.closest('.vote');
            const span = voteSection.querySelector('span#rating');
            const id = span.dataset.id;
            sendAjaxRequest('POST', '/answer/' + id + '/downvote', null, function () {
                const previous = span.innerHTML;
                let newRating;
                switch (this.status) {
                    case 201:
                        newRating = parseInt(previous) - 1;
                        break;
                    case 203:
                        newRating = parseInt(previous) - 2;
                        break;
                    case 205:
                        newRating = parseInt(previous) + 1;
                        break;
                    case 403:
                        alert("You cannot perform this action!");
                        break;
                    default:
                        console.error('Error:', this.statusText);
                        newRating = parseInt(previous);
                        break;
                }
                span.innerHTML = newRating.toString();
            });
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
                }
                else if (xhr.status === 403) {
                    alert("You cannot perform this action!");
                }
                else {
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
                }
                else if (xhr.status === 403) {
                    alert("You cannot perform this action!");
                }
                else {
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

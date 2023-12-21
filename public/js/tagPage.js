function editExistingTag(tagName) {
    const tagViewSection = document.getElementById('view' + tagName + 'Mode');
    const tagEditSection = document.getElementById('edit' + tagName + 'Mode');
    tagViewSection.style.display = 'none';
    tagEditSection.style.display = 'block';
}

function cancelEditExistingTag(tagName) {
    const tagViewSection = document.getElementById('view' + tagName + 'Mode');
    const tagEditSection = document.getElementById('edit' + tagName + 'Mode');
    tagViewSection.style.display = 'block';
    tagEditSection.style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    const deleteButton = document.getElementById('delete_tag');
    const editTagButton = document.getElementById('edit_tag');
    const cancelEditTagButton = document.getElementById('cancelButton');
    const applyEditTagButton = document.getElementById('applyButton');
    const followTagButton = document.getElementById('follow_tag');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (deleteButton) {
        deleteButton.addEventListener('click', function (e) {
            const confirmation = confirm('Are you sure you want to delete this question?');
            if (confirmation) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/tag/delete/' + window.tagName, true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                xhr.send();

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        window.location.replace('/tags');
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
            }
        });
    }

    if (editTagButton) {
        editTagButton.addEventListener('click', function (e) {
            const tagViewSection = document.getElementById('tag_info');
            const tagEditSection = document.getElementById('edit_tag_section');
            tagViewSection.style.display = 'none';
            tagEditSection.style.display = 'block';
        });
    }

    if (cancelEditTagButton) {
        cancelEditTagButton.addEventListener('click', function (e) {
            const tagViewSection = document.getElementById('tag_info');
            const tagEditSection = document.getElementById('edit_tag_section');
            tagViewSection.style.display = 'block';
            tagEditSection.style.display = 'none';
        });
    }

    if (applyEditTagButton) {
        applyEditTagButton.addEventListener('click', function (e) {
            e.preventDefault();
            const confirmation = confirm('Are you sure you want to edit this tag?');
            if (confirmation) {
                const applyForm = applyEditTagButton.closest('form');
                const url = applyForm.getAttribute('action');
                const method = applyForm.getAttribute('method');
                const newURL = document.getElementById('tag_name_edit').value;

                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        window.location.replace('/tag/' + newURL);
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

                xhr.send(new FormData(applyForm));
            }
        });
    }

    if (followTagButton) {
        followTagButton.addEventListener('click', function (e) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/tag/' + window.tagName + '/follow', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.send();

            xhr.onload = function () {
                const followCount = parseInt(document.getElementById('follow_count').innerHTML);
                switch (xhr.status) {
                    case 200:
                        followTagButton.innerHTML = 'Unfollow';
                        document.getElementById('follow_count').innerHTML = (followCount + 1).toString();
                        break;
                    case 201:
                        followTagButton.innerHTML = 'Follow';
                        document.getElementById('follow_count').innerHTML = (followCount - 1).toString();
                        break;
                    case 403:
                        alert("You cannot perform this action!");
                        break;
                    default:
                        console.error('Error:', xhr.statusText);
                        break;
                }
            };

            xhr.onerror = function () {
                console.error('Network error occurred');
            };
        });
    }
});
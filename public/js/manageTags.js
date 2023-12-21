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

function createNewTag() {
    const newTagSection = document.getElementById('new_tag');
    const newTagButton = document.getElementById('new_tag_button');
    newTagSection.style.display = 'block';
    newTagButton.style.display = 'none';
}

function cancelCreateNewTag() {
    const newTagSection = document.getElementById('new_tag');
    const newTagButton = document.getElementById('new_tag_button');
    newTagSection.style.display = 'none';
    newTagButton.style.display = 'block';
}

document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll('.delete_tag_button');

    const editTagButtons = document.querySelectorAll('.edit_tag_button');
    const cancelEditTagButtons = document.querySelectorAll('#cancelButton');

    const newTagButton = document.getElementById('new_tag_button');
    const cancelNewTagButton = document.getElementById('cancel_new_tag_button');

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const confirmation = confirm('Are you sure you want to delete this question?');
            if (confirmation) {
                const deleteForm = button.closest('form');
                const url = deleteForm.getAttribute('action');
                const method = deleteForm.getAttribute('method');

                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        window.location.reload();
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

                xhr.send(new FormData(deleteForm));
            }
        });
    });

    editTagButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const tagName = button.dataset.name;
            editExistingTag(tagName);
        });
    });

    cancelEditTagButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const tagName = button.dataset.name;
            cancelEditExistingTag(tagName);
        });
    });

    newTagButton.addEventListener('click', function (e) {
        e.preventDefault();

        createNewTag();
    });

    cancelNewTagButton.addEventListener('click', function (e) {
        e.preventDefault();

        cancelCreateNewTag();
    });
});
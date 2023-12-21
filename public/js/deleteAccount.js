document.addEventListener("DOMContentLoaded", function () {
    const deleteAccountButton = document.getElementById('delete_account_button');
    const deleteProfileButtons = document.querySelectorAll('.delete_profile_button');
    const blockUserButtons = document.querySelectorAll('.block_user');

    if (deleteAccountButton) {
        deleteAccountButton.addEventListener('click', function (e) {
            e.preventDefault();

            const confirmation = confirm('Are you sure you want to delete your account?');
            if (confirmation) {
                const deleteForm = deleteAccountButton.closest('form');
                const url = deleteForm.getAttribute('action');
                const method = deleteForm.getAttribute('method');

                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        window.location.reload();
                    } else {
                        console.error('Error:', xhr.statusText);
                    }
                };

                xhr.onerror = function () {
                    console.error('Network error occurred');
                };

                xhr.send(new FormData(deleteForm));
            }
        });
    }

    deleteProfileButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const confirmation = confirm('Are you sure you want to delete this account?');
            if (confirmation) {
                const deleteForm = button.closest('form');
                const url = deleteForm.getAttribute('action');
                const method = deleteForm.getAttribute('method');

                const xhr = new XMLHttpRequest();
                xhr.open(method, url, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        window.location.reload();
                    } else {
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

    blockUserButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            let confirmation;
            if (button.innerHTML === 'Block This User') {
                console.log('block');
                confirmation = confirm('Are you sure you want to block this user?');
            }
            else {
                console.log('unblock');
                confirmation = confirm('Are you sure you want to unblock this user?');
            }
            if (confirmation) {

                const id = button.closest('article').dataset.id;

                sendAjaxRequest('POST', '/block_user/' + id, null, function () {
                    switch (this.status) {
                        case 200:
                            button.innerHTML = 'Unblock This User';
                            break;
                        case 201:
                            button.innerHTML = 'Block This User';
                            break;
                        case 403:
                            alert('You cannot perform this action');
                            break;
                        default:
                            console.error('Error:', this.statusText);
                            break;
                    }
                });
            }
        });
    });
});
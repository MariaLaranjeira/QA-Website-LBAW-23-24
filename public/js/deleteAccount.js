document.addEventListener("DOMContentLoaded", function () {
    const deleteAccountButton = document.getElementById('delete_account_button');
    const deleteProfileButtons = document.querySelectorAll('.delete_profile_button');

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
});
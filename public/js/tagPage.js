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
    const deleteButton = document.getElementById('delete_tag_button');
});
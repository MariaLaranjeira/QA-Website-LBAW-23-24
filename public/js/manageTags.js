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
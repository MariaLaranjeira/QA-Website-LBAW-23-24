function editExistingTag(tagName) {
    console.log(tagName);
    const tagSection = document.getElementById('view' + tagName + 'Mode');
    tagSection.style.display = 'none';
}
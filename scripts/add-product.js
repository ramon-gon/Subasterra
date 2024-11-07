function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('image-preview');
    const instructions = document.getElementById('upload-instructions');
    const removeButton = document.getElementById('remove-image-btn');
    const imagePreviewContainer = document.getElementById('image-preview-container');

    reader.onload = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
        instructions.style.display = 'none';
        imagePreviewContainer.style.width = 'auto';
        removeButton.style.display = 'inline-block';
    };

    reader.readAsDataURL(event.target.files[0]);
}

function removeImage() {
    const preview = document.getElementById('image-preview');
    const instructions = document.getElementById('upload-instructions');
    const removeButton = document.getElementById('remove-image-btn');
    const fileInput = document.getElementById('photo');
    const imagePreviewContainer = document.getElementById('image-preview-container');

    preview.src = '#';
    preview.style.display = 'none';
    imagePreviewContainer.style.width = '400px';
    instructions.style.display = 'flex';
    removeButton.style.display = 'none';
    fileInput.value = ''; // Bàsicament buidem el valor del input file.
}
$(document).ready(function() {
    $('.select2').select2({
        width: '100%',
        placeholder: "Select one or more"
    });
});

const coverInput = document.getElementById('coverInput');
const coverPreview = document.getElementById('coverPreview');
const imgPreviewBox = document.getElementById('imgPreviewBox');
coverInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        coverPreview.classList.remove('default-plus');
        coverPreview.classList.add('uploaded-image');
        
        coverPreview.src = URL.createObjectURL(file);
    } else {
        resetToDefault();
    }
});

imgPreviewBox.addEventListener('click', function() {
    coverInput.click();
});

function resetToDefault() {
    coverPreview.classList.remove('uploaded-image');
    coverPreview.classList.add('default-plus');
    coverPreview.src = "{{ asset('assets/plus-icon.png') }}";
}

document.querySelector('form').addEventListener('reset', function() {
    setTimeout(resetToDefault, 100);
});

const instruction = document.querySelector('.upload-warning');

coverInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        instruction.style.display = "none";
    } else {
        instruction.style.display = "block";
    }
});
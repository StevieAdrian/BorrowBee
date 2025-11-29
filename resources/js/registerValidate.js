document.getElementById('registerForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    let isValid = true;

    if (!name.value.trim()) {
        name.classList.add('is-invalid');
        isValid = false;
    } else {
        name.classList.remove('is-invalid');
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value.trim())) {
        email.classList.add('is-invalid');
        isValid = false;
    } else {
        email.classList.remove('is-invalid');
    }

    if (password.value.trim().length < 8) {
        password.classList.add('is-invalid');
        isValid = false;
    } else {
        password.classList.remove('is-invalid');
    }

    if (password.value.trim() !== passwordConfirmation.value.trim()) {
        passwordConfirmation.classList.add('is-invalid');
        isValid = false;
    } else {
        passwordConfirmation.classList.remove('is-invalid');
    }

    if (!isValid) {
        e.preventDefault();
    }
});

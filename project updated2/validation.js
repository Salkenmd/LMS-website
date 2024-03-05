function isStrongPassword(password) {
    const hasLower = /[a-z]/.test(password);
    const hasUpper = /[A-Z]/.test(password);
    const hasDigit = /\d/.test(password);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
    const lengthCheck = password.length >= 8;

    return hasLower && hasUpper && hasDigit && hasSpecial && lengthCheck;
}

function validateForm() {
    const form = document.getElementById("registrationForm");
    const username = document.getElementById("username");
    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");
    const role = document.getElementById("role");

    if (username.value.trim() === "") {
        alert("Username cannot be empty.");
        username.focus();
        return false;
    }

    if (firstName.value.trim() === "") {
        alert("First Name cannot be empty.");
        firstName.focus();
        return false;
    }

    if (lastName.value.trim() === "") {
        alert("Last Name cannot be empty.");
        lastName.focus();
        return false;
    }

    if (email.value.trim() === "") {
        alert("Email cannot be empty.");
        email.focus();
        return false;
    }

    if (!isStrongPassword(password.value)) {
        alert("Password must be at least 8 characters long and contain at least one lowercase, one uppercase, one digit, and one special character.");
        password.focus();
        return false;
    }

    if (password.value !== confirmPassword.value) {
        alert("Passwords do not match.");
        password.focus();
        return false;
    }

    if (role.value === "") {
        alert("Role cannot be empty.");
        role.focus();
        return false;
    }

    form.submit();
    return true;
}

document.getElementById("registrationForm").addEventListener("submit", function(event) {
    event.preventDefault();
    validateForm();
});
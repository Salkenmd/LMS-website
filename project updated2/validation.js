// Function to check if a password is strong
function isStrongPassword(password) {
    const hasLower = /[a-z]/.test(password); // Check for lowercase letters
    const hasUpper = /[A-Z]/.test(password); // Check for uppercase letters
    const hasDigit = /\d/.test(password);     // Check for digits
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password); // Check for special characters
    const lengthCheck = password.length >= 8; // Check for minimum length of 8 characters

    // Return true if all conditions are met
    return hasLower && hasUpper && hasDigit && hasSpecial && lengthCheck;
}

window.onload = function() {
  document.getElementById("registrationForm").addEventListener("submit", function(event) {
    event.preventDefault();
    validateForm();
  });
}

// Function to validate the form
function validateForm() {
    const form = document.getElementById("registrationForm"); // Get the form element
    const username = document.getElementById("username"); // Get the username input element
    const firstName = document.getElementById("firstName"); // Get the first name input element
    const lastName = document.getElementById("lastName"); // Get the last name input element
    const email = document.getElementById("email"); // Get the email input element
    const password = document.getElementById("password"); // Get the password input element
    const confirmPassword = document.getElementById("confirmPassword"); // Get the confirm password input element
    const role = document.getElementById("role"); // Get the role input element

    // Check if username is empty
    if (username.value.trim() === "") {
        alert("Username cannot be empty."); // Show an alert
        username.focus(); // Focus on the username input field
        return false; // Return false to prevent form submission
    }

    // Check if first name is empty
    if (firstName.value.trim() === "") {
        alert("First Name cannot be empty."); // Show an alert
        firstName.focus(); // Focus on the first name input field
        return false; // Return false to prevent form submission
    }

    // Check if last name is empty
    if (lastName.value.trim() === "") {
        alert("Last Name cannot be empty."); // Show an alert
        lastName.focus(); // Focus on the last name input field
        return false; // Return false to prevent form submission
    }

    // Check if email is empty
    if (email.value.trim() === "") {
        alert("Email cannot be empty."); // Show an alert
        email.focus(); // Focus on the email input field
        return false; // Return false to prevent form submission
    }

    // Check if password is strong
    if (!isStrongPassword(password.value)) {
        alert("Password must be at least 8 characters long and contain at least one lowercase, one uppercase, one digit, and one special character."); // Show an alert
        password.focus(); // Focus on the password input field
        return false; // Return false to prevent form submission
    }

    // Check if password and confirm password match
    if (password.value !== confirmPassword.value) {
        alert("Passwords do not match."); // Show an alert
        password.focus(); // Focus on the password input field
        return false; // Return false to prevent form submission
    }

    // Check if role is empty
    if (role.value === "") {
        alert("Role cannot be empty."); // Show an alert
        role.focus(); // Focus on the role input field
        return false; // Return false to prevent form submission
    }

    // Submit the form if all validations pass
    form.submit();
    return true; // Return true to allow form submission
}

// Add event listener to the form submission event
document.getElementById("registrationForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission
    validateForm(); // Call the validateForm function to perform form validation
});

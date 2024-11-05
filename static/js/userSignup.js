const form = document.getElementById('signup-form');
const username_input = document.getElementById('username-input');
const email_input = document.getElementById('email-input');
const password_input = document.getElementById('password-input');
const repeat_password_input = document.getElementById('repeat-password-input');
const username = document.getElementById('username');
const email = document.getElementById('email');
const password = document.getElementById('password');
const repeatPassword = document.getElementById('repeat-password'); // Corrected ID
const username_errormsg = document.getElementById('username-error-msg');
const email_errormsg = document.getElementById('email-error-msg');
const password_errormsg = document.getElementById('password-error-msg');
const repeatPassword_errormsg = document.getElementById('repeat-password-error-msg'); // Corrected ID

username_input.addEventListener("input", validateUsername);
email_input.addEventListener("input", validateEmail);
password_input.addEventListener("input", validatePassword);
repeat_password_input.addEventListener("input", validateRepeatPassword);

function validateUsername() {
    const namePattern = /^[a-zA-Z0-9]+$/; // alphanumeric
    if (!username_input.value.match(namePattern)) {
        username.classList.add("incorrect");
        username_errormsg.textContent = "Username should only contain letters and numbers";
    } else {
        username.classList.remove("incorrect");
        username_errormsg.textContent = "";
    }
}

function validateEmail() {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}(?:\.[a-zA-Z]{2,})?$/;
    if (!email_input.value.match(emailPattern)) {
        email.classList.add("incorrect");
        email_errormsg.textContent = "Please enter a valid email";
    } else {
        email.classList.remove("incorrect");
        email_errormsg.textContent = "";
    }
}

function validatePassword() {
    const passwordPattern = /^(?=.*[A-Z])(?=.*\W).{12,}$/; // min 8 characters, 1 uppercase, 1 lowercase, 1 special character, 1 number
    if (!password_input.value.match(passwordPattern)) {
        password.classList.add("incorrect");
        password_errormsg.textContent = "Min 12 characters, 1 uppercase and 1 special character";
    } else {
        password.classList.remove("incorrect");
        password_errormsg.textContent = "";
    }
}

function validateRepeatPassword() {
    if (password_input.value !== repeat_password_input.value) {
        repeatPassword.classList.add("incorrect");
        repeatPassword_errormsg.textContent = "Passwords should match";
    } else {
        repeatPassword.classList.remove("incorrect");
        repeatPassword_errormsg.textContent = "";
    }
}

form.addEventListener("submit", function(event) {
    // Call all validation functions
    validateUsername();
    validateEmail();
    validatePassword();
    validateRepeatPassword();
    
    // Check if there are any error messages
    if (username.classList.contains("incorrect") ||
        email.classList.contains("incorrect") ||
        password.classList.contains("incorrect") ||
        repeatPassword.classList.contains("incorrect")) {
        
        // Prevent form submission
        event.preventDefault();
        alert("Please fix the errors in the form before submitting.");
    }
});

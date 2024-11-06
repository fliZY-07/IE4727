const form = document.getElementById('newOrder');
const email_input = document.getElementById('email');
const name_input = document.getElementById('name');
const cardNo_input = document.getElementById('cardNo');
const expiry_input = document.getElementById('expiry');
const cvv_input = document.getElementById('cvv');
const email_errormsg = document.getElementById('emailError');
const name_errormsg = document.getElementById('nameError');
const cardNo_errormsg = document.getElementById('cardNoError');
const expiry_errormsg = document.getElementById('expiryError');
const cvv_errormsg = document.getElementById('cvvError');

// email_input.addEventListener("input", validateEmail);
name_input.addEventListener("input", validateName);
cardNo_input.addEventListener("input", validateCardNo);
expiry_input.addEventListener("input", validateExpiry);
cvv_input.addEventListener("input", validateCVV);

// function validateEmail() {
//     const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}(?:\.[a-zA-Z]{2,})$/;
//     if (!email_input.value.match(emailPattern)) {
//         email_input.classList.add("incorrect");
//         email_errormsg.textContent = "Please enter a valid email";
//     } else {
//         email_input.classList.remove("incorrect");
//         email_errormsg.textContent = "";
//     }
// }

function validateName() {
    const namePattern = /^[a-zA-Z\s]+$/; // allows only alphabetic characters and spaces
    if (!name_input.value.match(namePattern)) {
        name_input.classList.add("incorrect");
        name_errormsg.textContent = "Name should only contain letters";
    } else {
        name_input.classList.remove("incorrect");
        name_errormsg.textContent = "";
    }
}

function validateCardNo() {
    const cardNoPattern = /^\d{4} \d{4} \d{4} \d{4}$/;
    if (!cardNo_input.value.match(cardNoPattern)) {
        cardNo_input.classList.add("incorrect");
        cardNo_errormsg.textContent = "Invalid card number or add space between every four digits";
    } else {
        cardNo_input.classList.remove("incorrect");
        cardNo_errormsg.textContent = "";
    }
}

cardNo_input.addEventListener('input', function (e) {
    e.target.value = e.target.value
        .replace(/\D/g, '')         // Remove non-digit characters
        .replace(/(.{4})/g, '$1 ')  // Add a space every four digits
        .trim();                    // Remove any trailing spaces
});

function validateExpiry() {
    const expiryPattern = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
    if (!expiry_input.value.match(expiryPattern)) {
        expiry_input.classList.add("incorrect");
        expiry_errormsg.textContent = "Expiry date must be in 'MM/YY' format";
    } else {
        expiry_input.classList.remove("incorrect");
        expiry_errormsg.textContent = "";
    }
}

expiry_input.addEventListener('input', function (e) {
    const value = e.target.value.replace(/\D/g, ''); // Remove non-numeric characters
    if (value.length >= 3) {
        e.target.value = `${value.slice(0, 2)}/${value.slice(2, 4)}`;
    } else {
        e.target.value = value;
    }
});

function validateCVV() {
    const cvvPattern = /^[0-9]{3}$/;
    if (!cvv_input.value.match(cvvPattern)) {
        cvv_input.classList.add("incorrect");
        cvv_errormsg.textContent = "Please enter a 3-digit number";
    } else {
        cvv_input.classList.remove("incorrect");
        cvv_errormsg.textContent = "";
    }
}

form.addEventListener("submit", function(event) {
    // Call all validation functions
    validateName();
    validateEmail();
    validateCardNo();
    validateExpiry();
    validateCVV();
    
    // Check if there are any error messages
    if (name_input.classList.contains("incorrect") ||
        cardNo_input.classList.contains("incorrect") ||
        expiry_input.classList.contains("incorrect") ||
        cvv_input.classList.contains("incorrect")) {
        
        // Prevent form submission
        event.preventDefault();
        alert("Please fix the errors in the form before submitting.");
    }
});

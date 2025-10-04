function validateContactForm() {
    let isValid = true;

    // First Name Validation
    const firstName = document.getElementById('firstName');
    const firstNameError = document.getElementById('firstNameError');
    if (!firstName.value.trim()) {
        firstNameError.style.display = 'block';
        isValid = false;
    } else {
        firstNameError.style.display = 'none';
    }

    // Last Name Validation
    const lastName = document.getElementById('lastName');
    const lastNameError = document.getElementById('lastNameError');
    if (!lastName.value.trim()) {
        lastNameError.style.display = 'block';
        isValid = false;
    } else {
        lastNameError.style.display = 'none';
    }

    // Email Validation ××××@×××.×××
    const email = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.trim() || !emailPattern.test(email.value)) {
        emailError.style.display = 'block';
        isValid = false;
    } else {
        emailError.style.display = 'none';
    }


    // Phone Validation 0*** *** ***
    const phone = document.getElementById('phone');
    const phoneError = document.getElementById('phoneError');
    const phonePattern = /^(?:\+61|0)[2-478](?:[ -]?[0-9]){8}$/;
    if (!phone.value.trim() || !phonePattern.test(phone.value)) {
        phoneError.style.display = 'block';
        isValid = false;
    } else {
        phoneError.style.display = 'none';
    }

    // Message Validation
    const message = document.getElementById('message');
    const messageError = document.getElementById('messageError');
    if (!message.value.trim()) {
        messageError.style.display = 'block';
        isValid = false;
    } else {
        messageError.style.display = 'none';
    }

    // Privacy Policy Validation
    const privacyPolicy = document.getElementById('privacyPolicy');
    const privacyPolicyError = document.getElementById('privacyPolicyError');
    if (!privacyPolicy.checked) {
        privacyPolicyError.style.display = 'block';
        isValid = false;
    } else {
        privacyPolicyError.style.display = 'none';
    }

    // If any validation fails, prevent form submission
    if (!isValid) {
        alert("Please fill out all required fields correctly.");
    }

    return isValid;
}

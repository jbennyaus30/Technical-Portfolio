// JavaScript for Contact Form Validation
const contactForm = document.getElementById("contact-form");

contactForm.addEventListener("submit", function (e) {
    e.preventDefault(); // Prevents page refresh

    // Get values from form inputs
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const message = document.getElementById("message").value.trim();

    // Check for empty fields
    if (!name || !email || !phone || !message) {
        alert("All fields are required!");
        return;
    }

    // Validate email format
    if (!validateEmail(email)) {
        alert("Please enter a valid email address!");
        return;
    }

    // Validate phone number format
    if (!validatePhoneNumber(phone)) {
        alert(
            "Please enter a valid phone number! It should start with a '+' followed by the country code and digits (e.g., +61 4XXXXXXXX)."
        );
        return;
    }

    // Success message and reset form
    alert("Thank you for contacting us! Your message has been sent.");
    contactForm.reset();
});

// Helper function to validate email format
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex for valid email
    return emailRegex.test(email);
}

// Helper function to validate phone number with country code
function validatePhoneNumber(phone) {
    // Regex explanation:
    // ^\+: Starts with a '+' (country code indicator)
    // \d{1,3}: Matches 1 to 3 digits for country code
    // \d{6,14}$: Matches 6 to 14 digits for the rest of the phone number
    const phoneRegex = /^\+\d{1,3}\d{6,14}$/;
    return phoneRegex.test(phone);
}

document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form"); // Get all forms (for login, create account, and forgot password pages)

    forms.forEach((form) => {
        const firstNameInput = form.querySelector("#firstName");
        const lastNameInput = form.querySelector("#lastName");
        const emailInput = form.querySelector("#email");
        const passwordInput = form.querySelector("#password");
        const firstNameError = form.querySelector("#firstNameError");
        const lastNameError = form.querySelector("#lastNameError");
        const emailError = form.querySelector("#emailError");
        const passwordError = form.querySelector("#passwordError");

        form.addEventListener("submit", function (event) {
            let isValid = true;

            // Reset error messages
            if (firstNameError) firstNameError.style.display = "none";
            if (lastNameError) lastNameError.style.display = "none";
            if (emailError) emailError.style.display = "none";
            if (passwordError) passwordError.style.display = "none";

            // Validate first name
            if (firstNameInput && !firstNameInput.value.trim()) {
                firstNameError.textContent = "Please enter your first name.";
                firstNameError.style.display = "block";
                isValid = false;
            }

            // Validate last name
            if (lastNameInput && !lastNameInput.value.trim()) {
                lastNameError.textContent = "Please enter your last name.";
                lastNameError.style.display = "block";
                isValid = false;
            }

            // Validate email
            if (emailInput && !emailInput.value.trim()) {
                emailError.textContent = "Please enter your email address.";
                emailError.style.display = "block";
                isValid = false;
            } else if (emailInput && !validateEmail(emailInput.value)) {
                emailError.textContent = "Please enter a valid email address.";
                emailError.style.display = "block";
                isValid = false;
            }

            // Validate password
            if (passwordInput) {
                const passwordValue = passwordInput.value.trim();
                if (!passwordValue) {
                    passwordError.textContent = "Please enter your password.";
                    passwordError.style.display = "block";
                    isValid = false;
                } else if (!validatePassword(passwordValue)) {
                    passwordError.textContent =
                        "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).";
                    passwordError.style.display = "block";
                    isValid = false;
                }
            }

            if (!isValid) {
                event.preventDefault(); // Prevent form submission
            }
        });
    });

    // Utility function to validate email
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Utility function to validate password
    function validatePassword(password) {
        const passwordRegex =
            /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return passwordRegex.test(password);
    }
});

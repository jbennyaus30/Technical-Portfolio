// Billing address page
function validateBillingForm() {
    let isValid = true;

    const fields = [
        { id: 'firstName', errorId: 'firstNameError', message: 'Please enter your first name.' },
        { id: 'lastName', errorId: 'lastNameError', message: 'Please enter your last name.' },
        { id: 'phone', errorId: 'phoneError', message: 'Please enter a valid phone number.' },
        { id: 'email', errorId: 'emailError', message: 'Please enter a valid email address.' },
        { id: 'country', errorId: 'countryError', message: 'Please select your country/region.' },
        { id: 'addressLine1', errorId: 'addressError', message: 'Please enter your street address.' },
        { id: 'suburb', errorId: 'suburbError', message: 'Please enter your suburb.' },
        { id: 'state', errorId: 'stateError', message: 'Please select your state.' },
        { id: 'postcode', errorId: 'postcodeError', message: 'Please enter your post code.' },
    ];

    fields.forEach(field => {
        const element = document.getElementById(field.id);
        const errorElement = document.getElementById(field.errorId);

        if (!element.value.trim()) {
            errorElement.textContent = field.message;
            errorElement.style.display = 'block';
            isValid = false;
        } else {
            errorElement.style.display = 'none';
        }
    });

    return isValid;
}


document.addEventListener("DOMContentLoaded", () => {
    const logoutLink = document.getElementById("logoutLink");

    if (logoutLink) {
        logoutLink.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent the default link behavior
            performLogout();
        });
    }

    function performLogout() {
        fetch('../logout.php', {
            method: 'POST',
        })
            .then((response) => {
                if (response.ok) {
                    // Redirect to the login page after logout
                    window.location.href = '../login/index.php';
                } else {
                    console.error("Logout failed. Response status:", response.status);
                    alert("An error occurred during logout. Please try again.");
                }
            })
            .catch((error) => {
                console.error("Logout request failed:", error);
                alert("An error occurred during logout. Please check your network connection.");
            });
    }
});

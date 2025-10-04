
// Validate the form before submitting
function validateForm(event) {
    const size = document.getElementById("size");
    const errorMsg = document.getElementById("sizeError");

    if (size.value === "") {
        event.preventDefault(); // Prevent form submission
        errorMsg.style.display = "block"; // Show error message
    }
}

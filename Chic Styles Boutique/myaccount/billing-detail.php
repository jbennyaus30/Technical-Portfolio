<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Details - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="myaccount.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../script.js"></script>
    <script src="myaccount.js"></script>
</head>

<?php
include '../config.php';
include '../header.php'; 
include '../db_connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch the user's name for the welcome message
$query = "SELECT user_first_name, user_last_name FROM USER WHERE user_id = ?";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $user = ['user_first_name' => '', 'user_last_name' => ''];
        error_log("User not found for user_id: $userId");
    }
} else {
    die("Error preparing statement: " . $conn->error);
}
?>

<body data-base-url="<?php echo BASE_URL; ?>">

<div id="overlay"></div>

<nav class="breadcrumbs">
    <ol>
        <li><a href="../index.php">Home</a></li>
        <li>My Account</li>
    </ol>
    <h2>My Account</h2>
</nav>

<div id="myaccount">
    <aside>
        <p class="welcome">
            Welcome, <?php echo htmlspecialchars($user['user_first_name'] . ' ' . $user['user_last_name']); ?>!
        </p>
        <hr>
        <nav>
            <ul>
                <li><a href="account-detail.php">Account Details →</a></li>
                <li><a href="billing-detail.php">Billing Details →</a></li>
                <li><a href="#" id="logoutLink">Log out →</a></li>
            </ul>
        </nav>
    </aside>

    <main>
        <section id="account-detail">
            <h3>Billing Details</h3>

            <form id="billingForm" method="POST" novalidate>
                <!-- Form fields -->
                <fieldset>
                    <label for="firstName">First Name <span class="mandatory">*</span></label>
                    <input type="text" id="firstName" name="firstName" required placeholder="Enter your first name">
                    <span class="error-message" id="firstNameError" style="display:none;">First name is required.</span>
                </fieldset>

                <fieldset>
                    <label for="lastName">Last Name <span class="mandatory">*</span></label>
                    <input type="text" id="lastName" name="lastName" required placeholder="Enter your last name">
                    <span class="error-message" id="lastNameError" style="display:none;">Last name is required.</span>
                </fieldset>

                <fieldset>
                    <label for="companyName">Company Name (optional)</label>
                    <input type="text" id="companyName" name="companyName" placeholder="Enter your company name (optional)">
                </fieldset>

                <fieldset>
                    <label for="phone">Phone <span class="mandatory">*</span></label>
                    <input type="tel" id="phone" name="phone" value="+61" required placeholder="Enter your phone number">
                    <span class="error-message" id="phoneError" style="display:none;">Please enter a valid phone number in +61 format.</span>
                </fieldset>

                <fieldset>
                    <label for="email">Email <span class="mandatory">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                    <span class="error-message" id="emailError" style="display:none;">Please enter a valid email address.</span>
                </fieldset>

                <fieldset>
                    <label for="country">Country/Region <span class="mandatory">*</span></label>
                    <select id="country" name="country" required>
                        <option value="Australia">Australia</option>
                    </select>
                    <span class="error-message" id="countryError" style="display:none;">Country is required.</span>
                </fieldset>

                <fieldset>
                    <label for="addressLine1">Street Address <span class="mandatory">*</span></label>
                    <input type="text" id="addressLine1" name="addressLine1" required placeholder="Enter your street address">
                    <input type="text" id="addressLine2" name="addressLine2" placeholder="Apartment, suite, etc. (optional)">
                    <span class="error-message" id="addressError" style="display:none;">Street address is required.</span>
                </fieldset>

                <fieldset>
                    <label for="suburb">Suburb <span class="mandatory">*</span></label>
                    <input type="text" id="suburb" name="suburb" required placeholder="Enter your suburb">
                    <span class="error-message" id="suburbError" style="display:none;">Suburb is required.</span>
                </fieldset>

                <fieldset>
                    <label for="state">State <span class="mandatory">*</span></label>
                    <select id="state" name="state" required>
                        <option value="" disabled selected>Select your state</option>
                        <option value="NSW">New South Wales (NSW)</option>
                        <option value="VIC">Victoria (VIC)</option>
                        <option value="QLD">Queensland (QLD)</option>
                        <option value="WA">Western Australia (WA)</option>
                        <option value="SA">South Australia (SA)</option>
                        <option value="TAS">Tasmania (TAS)</option>
                        <option value="ACT">Australian Capital Territory (ACT)</option>
                        <option value="NT">Northern Territory (NT)</option>
                    </select>
                    <span class="error-message" id="stateError" style="display:none;">State is required.</span>
                </fieldset>

                <fieldset>
                    <label for="postcode">Post Code <span class="mandatory">*</span></label>
                    <input type="text" id="postcode" name="postcode" required placeholder="Enter your post code">
                    <span class="error-message" id="postcodeError" style="display:none;">Post code is required.</span>
                </fieldset>

                <div class="submit_button">
                    <button type="button" id="updateButton">Update</button>
                </div>
            </form>
        </section>
    </main>
</div>

<?php include '../footer.php'; ?>

<script>
$(document).ready(function () {
    // Fetch billing details on page load
    $.ajax({
        url: "fetch_billing_details.php",
        method: "GET",
        dataType: "json",
        success: function (data) {
            if (data.success) {
                const details = data.billingDetails;

                // Populate form fields or set defaults
                $("#firstName").val(details.first_name || "");
                $("#lastName").val(details.last_name || "");
                $("#companyName").val(details.company_name || "");
                $("#phone").val(details.phone || "+61");
                $("#email").val(details.email || "");
                $("#country").val(details.country || "Australia");
                $("#addressLine1").val(details.address_line1 || "");
                $("#addressLine2").val(details.address_line2 || "");
                $("#suburb").val(details.suburb || "");
                $("#state").val(details.state || "");
                $("#postcode").val(details.postcode || "");
            } else {
                console.error("Failed to fetch billing details:", data.message);
                alert("Unable to load billing details. Please try again later.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching billing details:", status, error);
            alert("An error occurred while loading billing details.");
        }
    });

    // Update billing details with validation
    $("#updateButton").click(function () {
        const requiredFields = [
            { id: "firstName", error: "firstNameError", message: "First name is required." },
            { id: "lastName", error: "lastNameError", message: "Last name is required." },
            { id: "phone", error: "phoneError", message: "Please enter a valid phone number in +61 format." },
            { id: "email", error: "emailError", message: "Please enter a valid email address." },
            { id: "country", error: "countryError", message: "Country is required." },
            { id: "addressLine1", error: "addressError", message: "Street address is required." },
            { id: "suburb", error: "suburbError", message: "Suburb is required." },
            { id: "state", error: "stateError", message: "State is required." },
            { id: "postcode", error: "postcodeError", message: "Post code is required." },
        ];

        let isValid = true;

        // Phone number regex for Australian format
        const phoneRegex = /^\+61[2-478](?:[0-9]{8})$/;

        // Email regex
        const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;

        requiredFields.forEach(field => {
            const input = $("#" + field.id);
            const errorMessage = $("#" + field.error);

            // Reset error message visibility
            errorMessage.hide();

            // Check for empty values
            if (!input.val().trim()) {
                errorMessage.text(field.message).show();
                isValid = false;
            }

            // Additional format validation for specific fields
            if (field.id === "phone" && input.val().trim() && !phoneRegex.test(input.val().trim())) {
                errorMessage.text("Phone number must follow the +61XXXXXXXXX format.").show();
                isValid = false;
            }

            if (field.id === "email" && input.val().trim() && !emailRegex.test(input.val().trim())) {
                errorMessage.text("Invalid email address format.").show();
                isValid = false;
            }
        });

        if (!isValid) {
            console.log("Validation failed. Please correct errors and try again.");
            return;
        }

        console.log("Validation passed. Proceeding with submission...");

        // Prepare data for submission
        const formData = $("#billingForm").serialize();

        // AJAX Request to update billing details
        $.ajax({
            url: "update_billing_details.php",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Billing details updated successfully.");
                } else {
                    alert(response.message || "Failed to update billing details.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error updating billing details:", status, error);
                alert("An error occurred while updating billing details. Please try again.");
            }
        });
    });
});


</script>

</body>
</html>

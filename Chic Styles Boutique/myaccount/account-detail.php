<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="myaccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="myaccount.js"></script>
    <script src="../script.js"></script>
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
$query = "SELECT user_first_name, user_last_name, user_email, user_phone FROM USER WHERE user_id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $user = ['user_first_name' => '', 'user_last_name' => '', 'user_email' => '', 'user_phone' => ''];
        error_log("User not found for user_id: $userId");
    }
} else {
    die("Error preparing statement: " . $conn->error);
}
?>

<body data-base-url="<?php echo BASE_URL; ?>">


<!-- breadcrumbs -->
<nav class="breadcrumbs">
    <ol>
        <li><a href="../index.php">Home</a></li>
        <li>My Account</li>
    </ol>

    <h2>My Account</h2>
</nav>

<div id="myaccount">
    <!-- Left Sidebar -->
    <aside>
        <p class="welcome">Welcome, <?php echo htmlspecialchars($user['user_first_name'] . ' ' . $user['user_last_name']); ?>!</p>
        <hr>
        <nav>
            <ul>
                <li><a href="account-detail.php">Account Details →</a></li>
                <li><a href="billing-detail.php">Billing Details →</a></li>
                <li><a href="#" id="logoutLink">Log out →</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Section -->
    <main>
        <section id="account-detail">
            <h3>Account Details</h3>

            <!-- Account Details Form -->
            <form id="detailsForm">
                <fieldset>
                    <label for="firstName">First Name <span class="mandatory">*</span></label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['user_first_name']); ?>" required disabled>
                </fieldset>
                <fieldset>
                    <label for="lastName">Last Name <span class="mandatory">*</span></label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['user_last_name']); ?>" required disabled>
                </fieldset>
                <fieldset>
                    <label for="email">Email Address <span class="mandatory">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required disabled>
                </fieldset>
                <fieldset>
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['user_phone']); ?>" disabled>
                </fieldset>
                <div class="button-row">
                    <button type="button" id="editButton" class="edit-button"><i class="fas fa-pen"></i> Edit</button>
                    <button type="button" id="saveButton" class="save-button" disabled>Save Changes</button>
                </div>
            </form>

            <br>
            <hr>

            <!-- Password Change Form -->
            <h4>Password Change</h4>
            <form id="passwordForm" method="POST" novalidate>
            <fieldset>
                    <label for="currentPassword">Current Password <span class="mandatory">*</span></label>
                    <div class="password-field">
                        <input type="password" id="currentPassword" name="currentPassword" required>
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('currentPassword', this)">
                            <img src="../img/login/icon_eye-open.svg" alt="Show password" class="eye-open">
                            <img src="../img/login/icon_eye-close.svg" alt="Hide password" class="eye-closed" style="display: none;">
                        </span>
                    </div>
                    <div id="currentPasswordError" class="error-message" style="display: none;"></div>
                </fieldset>

                <fieldset>
                    <label for="newPassword">New Password <span class="mandatory">*</span></label>
                    <div class="password-field">
                        <input type="password" id="newPassword" name="newPassword" required>
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('newPassword', this)">
                            <img src="../img/login/icon_eye-open.svg" alt="Show password" class="eye-open">
                            <img src="../img/login/icon_eye-close.svg" alt="Hide password" class="eye-closed" style="display: none;">
                        </span>
                    </div>
                    <div id="newPasswordError" class="error-message" style="display: none;"></div>
                </fieldset>

                <fieldset>
                    <label for="confirmNewPassword">Confirm New Password <span class="mandatory">*</span></label>
                    <div class="password-field">
                        <input type="password" id="confirmNewPassword" name="confirmNewPassword" required>
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('confirmNewPassword', this)">
                            <img src="../img/login/icon_eye-open.svg" alt="Show password" class="eye-open">
                            <img src="../img/login/icon_eye-close.svg" alt="Hide password" class="eye-closed" style="display: none;">
                        </span>
                    </div>
                    <div id="confirmNewPasswordError" class="error-message" style="display: none;"></div>
                </fieldset>

                <button type="button" id="changePasswordButton">Change Password</button>

            </form>
        </section>
    </main>
</div>

<?php include '../footer.php'; ?>



</body>


<script>
    function togglePasswordVisibility(fieldId, toggleElement) {
        const passwordField = document.getElementById(fieldId);
        const eyeOpen = toggleElement.querySelector(".eye-open");
        const eyeClosed = toggleElement.querySelector(".eye-closed");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeOpen.style.display = "none";
            eyeClosed.style.display = "inline";
        } else {
            passwordField.type = "password";
            eyeOpen.style.display = "inline";
            eyeClosed.style.display = "none";
        }
    }

    // Save Changes Logic
    document.getElementById("saveButton").addEventListener("click", () => {
        const firstName = document.getElementById("firstName").value.trim();
        const lastName = document.getElementById("lastName").value.trim();
        const email = document.getElementById("email").value.trim();
        const phone = document.getElementById("phone").value.trim();

        if (!firstName || !lastName || !email) {
            alert("First Name, Last Name, and Email cannot be empty.");
            return;
        }

        if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        $.ajax({
            url: "update_account_details.php",
            method: "POST",
            dataType: "json",
            data: { firstName, lastName, email, phone },
            success: (response) => {
                alert(response.message || "Details updated successfully!");
                location.reload();
            },
            error: (xhr) => {
                alert(xhr.responseJSON?.message || "An error occurred. Please try again.");
            }
        });
    });

    document.getElementById("editButton").addEventListener("click", () => {
        const inputs = document.querySelectorAll("#detailsForm input");
        inputs.forEach(input => input.removeAttribute("disabled"));
        document.getElementById("saveButton").removeAttribute("disabled");
    });

    // Change Password Logic
    document.getElementById("changePasswordButton").addEventListener("click", function () {
        const currentPassword = document.getElementById("currentPassword").value.trim();
        const newPassword = document.getElementById("newPassword").value.trim();
        const confirmNewPassword = document.getElementById("confirmNewPassword").value.trim();

        const currentPasswordError = document.getElementById("currentPasswordError");
        const newPasswordError = document.getElementById("newPasswordError");
        const confirmNewPasswordError = document.getElementById("confirmNewPasswordError");

        // Reset error messages
        currentPasswordError.style.display = "none";
        newPasswordError.style.display = "none";
        confirmNewPasswordError.style.display = "none";

        let isValid = true;

        // Validate current password
        if (!currentPassword) {
            currentPasswordError.textContent = "Current password is required.";
            currentPasswordError.style.display = "block";
            isValid = false;
        }

        // Validate new password complexity
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&\-_=+,.<>?:;#^])[A-Za-z\d@$!%*?&\-_=+,.<>?:;#^]{8,}$/;
        if (!passwordRegex.test(newPassword)) {
            newPasswordError.textContent =
                "Password must include uppercase, lowercase, a number, and a special character.";
            newPasswordError.style.display = "block";
            isValid = false;
        }

        // Validate confirm new password
        if (newPassword !== confirmNewPassword) {
            confirmNewPasswordError.textContent = "Passwords do not match.";
            confirmNewPasswordError.style.display = "block";
            isValid = false;
        }

        // If validation fails, stop the process
        if (!isValid) {
            console.log("Validation failed. Fix errors and try again.");
            return;
        }

        console.log("Validation passed. Preparing to send AJAX request...");

        // AJAX Request to update password
        $.ajax({
            url: "update_password.php",
            method: "POST",
            dataType: "json",
            data: {
                currentPassword: currentPassword,
                newPassword: newPassword
            },
            beforeSend: function () {
                console.log("Sending AJAX request to update_password.php...");
            },
            success: function (response) {
                console.log("Response from server:", response);
                if (response.success) {
                    alert(response.message || "Password changed successfully.");
                    document.getElementById("passwordForm").reset(); // Reset the form
                } else {
                    // Display backend error message for incorrect current password
                    currentPasswordError.textContent =
                        response.message || "Current password is incorrect.";
                    currentPasswordError.style.display = "block";
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed. Status:", status, "Error:", error);
                const errorMessage = xhr.responseJSON?.message || "An error occurred.";
                currentPasswordError.textContent = errorMessage;
                currentPasswordError.style.display = "block";
            }
        });
    });


</script>

</html>

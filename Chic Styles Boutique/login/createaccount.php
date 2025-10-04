<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../script.js"></script>
    <script src="login.js"></script>
</head>
<body>

    <header id="header_fix">
        <div class="container" style="padding: 10px 0; justify-content: center;">
            <!-- Logo -->
            <h1 style="margin: 20px auto;"><a href="../index.php"><img src="../img/header/logo.png" alt="Chic Styles Boutique" title="Chic Styles Boutique"></a></h1>
        </div>
    </header>

    <div id="overlay"></div>
    
    <main>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="../index.php">Home</a></li>
                <li>Create Account</li>
            </ol>
            <h2>Create Account</h2>
        </nav>

        <section id="login" class="createaccount">
            <form action="register.php" method="POST" id="contactForm" onsubmit="return validateForm()" novalidate>
                <!-- First Name -->
                <fieldset>
                    <label for="firstName">First Name <span class="mandatory">*</span></label>
                    <input type="text" id="firstName" name="firstName" required placeholder="Enter your first name">
                    <span class="error-message" id="firstNameError">Please enter your first name.</span>
                </fieldset>
            
                <!-- Last Name -->
                <fieldset>
                    <label for="lastName">Last Name <span class="mandatory">*</span></label>
                    <input type="text" id="lastName" name="lastName" required placeholder="Enter your last name">
                    <span class="error-message" id="lastNameError">Please enter your last name.</span>
                </fieldset>
            
                <!-- Email address -->
                <fieldset>
                    <label for="email">Email address <span class="mandatory">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                    <span class="error-message" id="emailError">Please enter a valid email address.</span>
                </fieldset>
            
                <!-- Password -->
                <fieldset>
                    <label for="password">Password <span class="mandatory">*</span></label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" required placeholder="Enter your password">
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('password', this)">
                            <img src="../img/login/icon_eye-open.svg" alt="" class="eye-open">
                            <img src="../img/login/icon_eye-close.svg" alt="" class="eye-closed" style="display: none;">
                        </span>
                    </div>                                    
                    <span class="error-message" id="passwordError">Password must be at least 8 characters, include one uppercase, one lowercase, one number, and one special character.</span>
                </fieldset>

                <!-- Confirm Password -->
                <fieldset>
                    <label for="confirmPassword">Confirm Password <span class="mandatory">*</span></label>
                    <div class="password-field">
                        <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Re-enter your password">
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('confirmPassword', this)">
                            <img src="../img/login/icon_eye-open.svg" alt="" class="eye-open">
                            <img src="../img/login/icon_eye-close.svg" alt="" class="eye-closed" style="display: none;">
                        </span>
                    </div>                                        
                    <span class="error-message" id="confirmPasswordError">Passwords do not match.</span>
                </fieldset>
            
                <!-- Privacy Policy -->
                <fieldset>
                    <label class="privacypolicy">
                        <input type="checkbox" id="privacypolicy" name="privacypolicy">
                        <p>I have read and accept the <a href="../privacypolicy/index.php" target="_blank">Privacy Policy</a> and <a href="../termsofuse/index.php" target="_blank">Terms of Use</a>.</p>
                    </label>
                    <span class="error-message" id="policyError">Please accept the Privacy Policy and Terms of Use.</span>
                </fieldset>
            
                <!-- Submit Button -->
                <div class="submit_button">
                    <button type="submit">Create Account</button>
                </div>
                <!-- Login link -->
                <p class="already-have-account"><a href="index.php">Already have an account?</a></p>
            </form>
        </section>
    </main>

    <?php include '../footer.php'; ?>

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

        function validateForm() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            const policyCheckbox = document.getElementById("privacypolicy");
            const policyError = document.getElementById("policyError");

            let isValid = true;

            if (!policyCheckbox.checked) {
                policyError.style.display = "block";
                isValid = false;
            } else {
                policyError.style.display = "none";
            }

            if (password !== confirmPassword) {
                document.getElementById("confirmPasswordError").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("confirmPasswordError").style.display = "none";
            }

            return isValid;
        }
    </script>
</body>
</html>

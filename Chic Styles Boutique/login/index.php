<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../script.js"></script>
    <script src="login.js"></script>
</head>
<body>

    <header id="header_fix">
        <div class="container">
               
            <!-- Logo -->
            <h1 style="margin: 20px auto;"><a href="../index.php"><img src="../img/header/logo.png" alt="Chic Styles Boutique" title="Chic Styles Boutique"></a></h1>
    
        </div>
    </header>

    <!-- background-overlay -->
    <div id="overlay"></div>
    
    <main>
        <!-- breadcrumbs -->
        <nav class="breadcrumbs">
            <ol>
                <li><a href="../index.php">Home</a></li>
                <li>Login</li>
            </ol>
            <h2>Login</h2>
        </nav>

        <section id="login">
            <form action="login.php" method="POST" id="loginForm">
                <!-- Email Address -->
                <fieldset>
                    <label for="email">Email address <span class="mandatory">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                </fieldset>

                <!-- Password -->
                <fieldset>
                    <label for="password">Password <span class="mandatory">*</span></label>
                    <div class="password-field">
                        <input type="password" id="password" name="password" required placeholder="Enter your password">
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility('password', this)">
                            <img src="../img/login/icon_eye-open.svg" alt="Show password" class="eye-open">
                            <img src="../img/login/icon_eye-close.svg" alt="Hide password" class="eye-closed" style="display: none;">
                        </span>
                    </div>

                    <div id="errorMessage" class="error-message" style="display: none;"></div>
                </fieldset>
                

                <!-- Remember Me -->
                <fieldset>
                    <label class="remenberme">
                        <input type="checkbox" id="remenberme" name="remenberme">
                        <p>Remember me</p>
                    </label>
                </fieldset>
        
                <!-- Submit Button -->
                <div class="submit_button">
                    <button type="submit">Login</button>
                    <button type="button" onclick="location.href='createaccount.php'">Create New Account</button>
                </div>
                <p class="forgot"><a href="forgotpass.php">Forgot Password</a></p>
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


        // Display error messages based on query string
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');
        const errorMessage = document.getElementById('errorMessage');

        if (error === 'invalid_credentials') {
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Invalid email or password. Please try again.';
        } else if (error === 'empty_fields') {
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Please fill in all fields.';
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="login.css">
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
                <li><a href="index.php">Login</a></li>
                <li>Forgot Password</li>
            </ol>

            <h2>Forgot Password</h2>
        </nav>

        <section id="login" class="forgotpass">


            <p>Please enter your username or email address. You will receive a link to create a new password via email.</p>

            <form action="forgot_password.php" method="POST" id="forgotPasswordForm" onsubmit="return validateForgotPasswordForm()" novalidate>
                <!-- Email Address -->
                <fieldset>
                    <label for="email">Email address <span class="mandatory">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                    <span class="error-message" id="emailError">Please enter a valid email address.</span>
                </fieldset>
            
                <!-- Submit Button -->
                <div class="submit_button">
                    <button type="submit">Reset Password</button>
                </div>
            </form>
            
            <script>
                function validateForgotPasswordForm() {
                    const email = document.getElementById("email").value.trim();
                    const emailError = document.getElementById("emailError");
            
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
                    if (!email) {
                        emailError.textContent = "Please enter your email address.";
                        emailError.style.display = "block";
                        return false;
                    } else if (!emailRegex.test(email)) {
                        emailError.textContent = "Please enter a valid email address.";
                        emailError.style.display = "block";
                        return false;
                    } else {
                        emailError.style.display = "none";
                        return true;
                    }
                }
            </script>
            

        </section>
    
    </main>
    

    <?php include '../footer.php'; ?>


    <script>
        function validateForgotPasswordForm() {
            const email = document.getElementById("email").value.trim();
            const emailError = document.getElementById("emailError");
    
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
            if (!email) {
                emailError.textContent = "Please enter your email address.";
                emailError.style.display = "block";
                return false;
            } else if (!emailRegex.test(email)) {
                emailError.textContent = "Please enter a valid email address.";
                emailError.style.display = "block";
                return false;
            } else {
                emailError.style.display = "none";
                return true;
            }
        }
    </script>


</body>
</html>

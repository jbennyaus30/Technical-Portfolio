<?php 
session_start();
require_once '../config.php'; // Include the configuration file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Chic Style Boutique</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>style.css">
    <link rel="stylesheet" href="admin-login.css">
    <script src="<?php echo BASE_URL; ?>script.js"></script>
    <script src="admin-login.js"></script>
</head>
<body>
    <header id="header_fix">
        <div class="container">    
            <h1><a href="<?php echo BASE_URL; ?>index.php">
                <img src="<?php echo BASE_URL; ?>img/header/logo.png" alt="Chic Styles Boutique">
            </a></h1>
        </div>
    </header>

    <main>
        <section id="admin-login">
            <form action="<?php echo BASE_URL; ?>admin/login.php" method="POST" id="contactForm" onsubmit="return validateContactForm()" novalidate>
                <fieldset>
                    <label for="email">Email address <span class="mandatory">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                    <span class="error-message" id="emailError">Please enter a valid email address.</span>
                </fieldset>

                <fieldset>
                    <label for="password">Password <span class="mandatory">*</span></label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <span class="error-message" id="passwordError">Please enter a valid password.</span>
                </fieldset>

                <fieldset>
                    <label class="remenberme">
                        <input type="checkbox" id="remenberme" name="remenberme">
                        <p>Remember me</p>
                    </label>
                </fieldset>

                <div class="submit_button">
                    <button type="submit">Login</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <div class="container">
            <small>©<?php echo date('Y'); ?> All Rights Reserved</small>
        </div>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Chic Style Boutique</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="contactus.css">
    <script src="../script.js"></script>
    <script src="contactus.js"></script>
</head>

<?php include '../config.php'; ?>
<?php include '../header.php'; ?>
<body data-base-url="<?php echo BASE_URL; ?>">

    <!-- background-overlay -->
    <div id="overlay"></div>
    
    <main>

        <!-- breadcrumbs -->
        <nav class="breadcrumbs">
            <ol>
                <li><a href="../index.php">Home</a></li>
                <li>Contact Us</li>
            </ol>

            <h2>Contact Us</h2>
        </nav>

        <section class="contactus">
            <h3 class="contactus_title">Do you have questions or need assistance?</h3>
            <p class="contactus_description">Fill out the form below, and one of our team members will get in touch with you shortly.</p>

            <form action="#" id="contactForm" onsubmit="return validateContactForm()" novalidate>
                <!-- Name -->
                <fieldset>
                    <div class="firstname">
                        <label for="firstName">First Name <span class="mandatory"> <span class="mandatory">*</span></span></label>
                        <input type="text" id="firstName" name="firstName" required placeholder="Enter your first name">
                        <span class="error-message" id="firstNameError">This field is required.</span>
                    </div>
        
                    <div>
                        <label for="lastName">Last Name <span class="mandatory"> <span class="mandatory">*</span></span></label>
                        <input type="text" id="lastName" name="lastName" required placeholder="Enter your last name">
                        <span class="error-message" id="lastNameError">This field is required.</span>
                    </div>
                </fieldset>
        
                <!-- Company -->
                <fieldset>
                    <label for="companyName">Company Name <small>(optional)</small></label>
                    <input type="text" id="companyName" name="companyName" placeholder="Enter your company name">
                </fieldset>
        
                <!-- Email -->
                <fieldset>
                    <label for="email">Email <span class="mandatory">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                    <span class="error-message" id="emailError">Please enter a valid email address.</span>
                </fieldset>

                <!-- Phone Section -->
                <fieldset>
                    <label for="phone">Phone <span class="mandatory">*</span></label>
                    <div class="phone-input-wrapper">
                        <span id="countryCode">+61</span>
                        <input type="tel" id="phone" name="phone" required placeholder="Enter your phone number" 
                            pattern="^(?:\+61|0)[2-478](?:[ -]?[0-9]){8}$" title="Enter a valid Australian phone number">
                    </div>
                    <span class="error-message" id="phoneError">Please enter a valid phone number. (e.g. 04xx xxx xxx)</span>
                </fieldset>
            
                <!-- Message -->
                <fieldset>
                    <label for="message">Message <span class="mandatory">*</span></label>
                    <textarea id="message" name="message" rows="5" required placeholder="Enter your message"></textarea>
                    <span class="error-message" id="messageError">This field is required.</span>
                </fieldset>
        
                <!-- Privacy Policy -->
                <fieldset>
                    <label class="agreement">
                        <input type="checkbox" id="privacyPolicy" name="privacyPolicy" required>
                        <p>I confirm that I have read and agree to the <a href="../privacypolicy/index.php" style="border-bottom: 1px solid #000;" target="_blank">Privacy Policy.</a> <span class="mandatory">*</span></p>
                    </label>
                    <span class="error-message" id="privacyPolicyError">You must agree to the Privacy Policy.</span>
                </fieldset>
        
                <!-- Submit Button -->
                <div class="submit"><button type="submit">Submit</button></div>
            </form>

        </section>
    
    </main>
    

    <?php include '../footer.php'; ?>


</body>
</html>

<!doctype html>
<html>

<head>

    <title>Create Account - DriveHub</title>
    <link rel="stylesheet" href="css/register.css">
    <script src="js/registerValidation.js" defer></script>
    <script src="js/index.js" defer></script>

</head>

<body>

    <div class="register-screen">

        <div class="register-left">
            
            <a href="landing.php" class="homepage">

                <div class="logo">
                    <div class="logo-emoji">&#128663;</div>
                    <div class="logo-text">DRIVE<span>HUB</span></div>
                </div>

            </a>

            

            <div>

                <div class="tagline">PREMIUM AUTOMOTIVE</div>

                <div class="headline">Find Your<br>Next Drive.</div>

                    <p class="para">
                        Explore our curated collection of world-class vehicles.
                        Browse specifications, schedule test drives, and connect
                        with our expert team - all in one place.
                    </p>

            </div>

            <div class="copyright">&copy; 2026 DriveHub. All rights reserved.</div>

        </div>

        <div class="register-right">

            <div class="register-form-box">

                <div class="reg-tabs">
                    <a href="login.php" class="tab-link">Sign In</a>
                    <a href="register.php" class="tab-link tab-link-active">Create Account</a>
                </div>

                <div class="reg-title">Create an account</div> <br>

                <form action="../controllers/registerControls.php" method="post" onsubmit="return validateRegisterForm()">

                    <div class="form-group">

                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="input" id="name" name="name" placeholder="Abrar Kabir">
                        
                        <span class="error-text" id="nameErr">

                            <?php
                                if(isset($_GET["nameErr"]))
                                {
                                    echo htmlspecialchars($_GET["nameErr"]);
                                }
                            ?>

                        </span>

                    </div>

                    <div class="form-group">

                        <label for="email" class="form-label">Email Address</label>
                        <input type="text" class="input" id="email" name="email" placeholder="you@example.com">

                        <span class="error-text" id="emailErr">

                            <?php
                                if(isset($_GET["emailErr"]))
                                {
                                    echo htmlspecialchars($_GET["emailErr"]);
                                }
                            ?>

                        </span>

                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="input" id="phone" name="phone" placeholder="+8801XXXXXXXXX">
                        
                        <span class="error-text" id="phoneErr">

                            <?php
                                if(isset($_GET["phoneErr"]))
                                {
                                    echo htmlspecialchars($_GET["phoneErr"]);
                                }
                            ?>

                        </span>

                    </div>

                    <div class="form-group">

                        <label for="password" class="form-label">Password</label>

                        <div class="pass-wrap">
                            <input type="password" class="input" id="password" name="password" placeholder="Create a password">
                            <button type="button" class="show-btn" onclick="togglePassword('password', this)">Show</button>
                        </div>

                        <span class="error-text" id="passwordErr">

                            <?php
                                if(isset($_GET["passwordErr"]))
                                {
                                    echo htmlspecialchars($_GET["passwordErr"]);
                                }
                            ?>

                        </span>

                    </div>

                    <div class="form-group">

                        <label for="conPassword" class="form-label">Confirm Password</label>

                        <div class="pass-wrap">
                            <input type="password" class="input" id="conPassword" name="conPassword" placeholder="Type the password again">
                            <button type="button" class="show-btn" onclick="togglePassword('conPassword', this)">Show</button>
                        </div>

                        <span class="error-text" id="conPasswordErr">

                            <?php
                                if(isset($_GET["conPasswordErr"]))
                                {
                                    echo htmlspecialchars($_GET["conPasswordErr"]);
                                }
                            ?>

                        </span>

                    </div>

                    <div class="form-group">

                        <label for="securityQuestion" class="form-label">Security Question</label>

                        <select class="select" id="securityQuestion" name="securityQuestion">
                            <option value="">Select a question</option>
                            <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                            <option value="What city were you born in?">What city were you born in?</option>
                            <option value="What is your favourite book?">What is your favourite book?</option>
                        </select>

                        <span class="error-text" id="securityQuestionErr">

                            <?php
                                if(isset($_GET["securityQuestionErr"]))
                                {
                                    echo htmlspecialchars($_GET["securityQuestionErr"]);
                                }
                            ?>

                        </span>

                    </div>

                    <div class="form-group">

                        <label for="securityAnswer" class="form-label">Security Answer</label>
                        <input type="text" class="input" id="securityAnswer" name="securityAnswer" placeholder="Used to recover your password">
                        
                        <span class="error-text" id="securityAnswerErr">

                            <?php
                                if(isset($_GET["securityAnswerErr"]))
                                {
                                    echo htmlspecialchars($_GET["securityAnswerErr"]);
                                }
                            ?>

                        </span>

                    </div>

                    <input type="submit" class="btn btn-primary btn-block" name="submit" value="Create Account">
                    
                </form>

                <div class="footer">
                    Already have an account? <a href="login.php">Sign in</a>
                </div>

            </div>
        </div>

    </div>
</body>

</html>

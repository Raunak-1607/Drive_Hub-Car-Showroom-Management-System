<!doctype html>
<html>

<head>

    <title>Login - DriveHub</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="js/index.js" defer></script>
    
</head>

<body>

    <div class="login-screen">

        <div class="login-left">

            <a class="homepage" href="landing.php">

                 <div class="logo">
                    <div class="logo-emoji">&#128663;</div>
                    <div class="logo-text">DRIVE<span class="logo-text2">HUB</span></div>
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

        <div class="login-right">

            <div class="form-box">

                <div class="tabs">
                    <a href="login.php" class="login-tab tab-active">Sign In</a>
                    <a href="register.php" class="login-tab">Create Account</a>
                </div>

                <div class="title">Welcome back</div>
                <br>

                <form action="../controllers/loginControls.php" method="post">

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>

                        <input type="email" class="input" id="email" name="email" placeholder="you@example.com">

                        <span class="error-text">

                            <?php
                            if (isset($_GET["emailErr"])) {
                                echo htmlspecialchars($_GET["emailErr"]);
                            }
                            ?>
                            
                        </span>
                    </div>

                    <div class="form-group">

                        <label for="password" class="form-label">Password</label>

                        <div class="pass-box">
                            <input type="password" class="input password-input" id="password" name="password" placeholder="Enter your password">

                            <button type="button" class="show-btn" onclick="togglePassword('password', this)">
                                Show
                            </button>
                        </div>

                        <span class="error-text">

                            <?php
                            if (isset($_GET["passwordErr"])) {
                                echo htmlspecialchars($_GET["passwordErr"]);
                            }
                            ?>

                        </span>

                        <span class="error-text">

                            <?php
                            if (isset($_GET["loginErr"])) {
                                echo htmlspecialchars($_GET["loginErr"]);
                            }
                            ?>

                        </span>

                    </div>

                    <div class="forgotPass">
                        <span></span>
                        <a href="forgotPassword.php" class="forgot">Forgot password?</a>
                    </div>

                    <input type="submit" class="login-button" name="submit" value="Sign In">

                </form>

                <div class="footer">
                    New customer? <a href="register.php" class="register">Create an account</a>
                </div>

            </div>

        </div>

    </div>

</body>

</html>
<!doctype html>
<html>

<head>

    <title>Set a New Password - DriveHub</title>
    <link rel="stylesheet" href="css/reset.css">
    <script src="js/index.js" defer></script>

</head>

<body>

    <div class="resetPage">

        <div class="page-left">

            <div class="logo">
                <div class="logo-emoji">&#128663;</div>
                <div class="logo-text">DRIVE<span>HUB</span></div>
            </div>

            <div>
                <div class="tagline">Premium Automotive</div>
                <div class="headline">Find Your<br>Next Drive.</div>

                <p class="para">
                    Explore our curated collection of world-class vehicles.
                    Browse specifications, schedule test drives, and connect
                    with our expert team - all in one place.
                </p>

            </div>

            <div class="copyright">&copy; 2026 DriveHub. All rights reserved.</div>

        </div>

        <div class="page-right">

            <div class="form-box">

                <a href="login.php" class="backPage"><b><- Back to Sign In </b></a>


                <div class="title">Set a New Password</div>
                <div class="subtitle">Your identity has been verified. Choose a new password.</div>

                <form action="../controllers/forgotPasswordControls.php?action=reset" method="post">

                    <div class="group">

                        <label for="newPassword">New Password</label>

                        <div class="pass-wrap">
                            <input type="password" class="input" id="newPassword" name="newPassword">
                            <button type="button" class="show-btn" onclick="togglePassword('newPassword', this)">Show</button>
                        </div>

                        <span class="error-text">

                            <?php

                                if(isset($_GET["newPasswordErr"]))
                                {
                                    echo htmlspecialchars($_GET["newPasswordErr"]);
                                }

                            ?>

                        </span>

                    </div>

                    <div class="form-group">

                        <label for="conPassword">Confirm New Password</label>

                        <div class="pass-wrap">
                            <input type="password" class="input" id="conPassword" name="conPassword">
                            <button type="button" class="show-btn" onclick="togglePassword('conPassword', this)">Show</button>
                        </div>

                        <span class="error-text">

                            <?php
                                if(isset($_GET["conPasswordErr"]))
                                {
                                    echo htmlspecialchars($_GET["conPasswordErr"]);
                                }
                            ?>

                        </span>
                        
                    </div>

                    <input type="submit" class="btn btn-primary btn-block" name="submit" value="Update Password">

                </form>

            </div>

        </div>

    </div>
    
</body>

</html>

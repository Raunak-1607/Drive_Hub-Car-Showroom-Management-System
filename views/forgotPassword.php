<!doctype html>
<html>

<head>

    <title>Forgot Password - DriveHub</title>
    <link rel="stylesheet" href="css/forgot.css">

</head>

<body>
    <div class="forgotPage">

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

                <a href="login.php" class="backPage"><b><- Back to Sign In</b></a>

                <div class="title">Forgot Password?</div>

                <div class="subtitle">
                    Answer the security question you set during registration to verify your identity.
                </div>

                <?php

                    if(isset($_GET["verifyErr"]))
                    {
                        echo '<div class="alert alert-error">'.htmlspecialchars($_GET["verifyErr"]).'</div>';
                    }
                    
                ?>

                <form action="../controllers/forgotPasswordControls.php?action=verify" method="post">

                    <div class="group">

                        <label for="email">Email Address</label>
                        <input type="email" class="input" id="email" name="email" placeholder="you@example.com">

                        <span class="error-text">

                            <?php
                                if(isset($_GET["emailErr"]))
                                {
                                    echo htmlspecialchars($_GET["emailErr"]);
                                }
                            ?>

                        </span>
                    </div>

                    <div class="group">

                        <label for="securityQuestion">Security Question</label>

                        <select class="select" id="securityQuestion" name="securityQuestion">
                            <option value="">Select your question</option>
                            <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                            <option value="What city were you born in?">What city were you born in?</option>
                            <option value="What is your favourite book?">What is your favourite book?</option>
                        </select>
                        
                        <span class="error-text">

                            <?php
                                if(isset($_GET["securityQuestionErr"]))
                                {
                                    echo htmlspecialchars($_GET["securityQuestionErr"]);
                                }
                            ?>

                        </span>

                    </div>

                    <div class="group">

                        <label for="securityAnswer">Your Answer</label>
                        <input type="text" class="input" id="securityAnswer" name="securityAnswer" placeholder="Type your answer...">

                        <span class="error-text">

                            <?php
                                if(isset($_GET["securityAnswerErr"]))
                                {
                                    echo htmlspecialchars($_GET["securityAnswerErr"]);
                                }
                            ?>

                        </span>
                    </div>

                    <input type="submit" class="btn btn-primary btn-block" name="submit" value="Verify and Continue">

                </form>

            </div>
        </div>

    </div>
</body>

</html>

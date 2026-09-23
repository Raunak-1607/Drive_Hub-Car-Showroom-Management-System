<?php

session_start();

if(!isset($_SESSION["userId"]) || $_SESSION["role"]!="customer")
{
    header("Location: ../login.php");
    exit();
}

$activePage="profile";

$wrapClass="page-wrap";
?>

<!doctype html>
<html>

<head>
    <title>Change Password - DriveHub</title>
    <link rel="stylesheet" href="../css/customercngpass.css">
    <script src="../js/index.js" defer></script>
</head>

<body>

    <div class="<?php echo $wrapClass; ?>">
        <div class="modal-card modal-center">

            <div class="modal-head">

                <div>
                    <div class="modal-title">Change Password</div>
                    <div class="modal-note">
                        Used by customers, employees and admins. Enter your current password to confirm it's you.
                    </div>
                </div>

                <a href="profile.php" class="modal-close">&times;</a>

            </div>

            <form action="../../controllers/accountControls.php?action=changePassword" method="post">

                <div class="form-group">

                    <label for="currentPassword">Current Password</label>

                    <div class="pass-wrap">
                        <input type="password" class="input" id="currentPassword" name="currentPassword">
                        <button type="button" class="show-btn" onclick="togglePassword('currentPassword', this)">Show</button>
                    </div>

                    <span class="error-text">
                        <?php
                            if(isset($_GET["currentPasswordErr"]))
                            {
                                echo htmlspecialchars($_GET["currentPasswordErr"]);
                            }
                        ?>
                    </span>

                </div>

                <div class="form-group">

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

                <div class="form-actions">
                    <a href="profile.php" class="btn btn-secondary">Cancel</a>
                    <input type="submit" class="btn btn-primary" name="submit" value="Update Password">
                </div>

            </form>

        </div>
    </div>
</body>

</html>

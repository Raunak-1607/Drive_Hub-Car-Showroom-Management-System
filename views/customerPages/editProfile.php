<?php

session_start();

if(!isset($_SESSION["userId"]) || $_SESSION["role"]!="customer")
{
    header("Location: ../login.php");
    exit();
}

require_once "../../models/usersModel.php";

$activePage="profile";
$user=getUserById($_SESSION["userId"]);

$wrapClass="page-wrap";
?>

<!doctype html>
<html>

<head>
    <title>Edit Profile - DriveHub</title>
    <link rel="stylesheet" href="../css/editProfile.css">
</head>

<body>

    <div class="<?php echo $wrapClass; ?>">

        <div class="modal-card modal-center">

            <div class="modal-head">

                <div>
                    <div class="modal-title">Edit Profile</div>
                    <div class="modal-note">Update your name, email address and phone number.</div>
                </div>

                <a href="profile.php" class="modal-close">&times;</a>

            </div>

            <form action="../../controllers/accountControls.php?action=updateProfile" method="post">

                <div class="form-group">

                    <label for="name">Full Name</label>
                    <input type="text" class="input" id="name" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>">

                    <span class="error-text">
                        <?php
                            if(isset($_GET["nameErr"]))
                            {
                                echo htmlspecialchars($_GET["nameErr"]);
                            }
                        ?>
                    </span>

                </div>

                <div class="form-group">

                    <label for="email">Email Address</label>
                    <input type="text" class="input" id="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>">

                    <span class="error-text">
                        <?php
                            if(isset($_GET["emailErr"]))
                            {
                                echo htmlspecialchars($_GET["emailErr"]);
                            }
                        ?>
                    </span>

                </div>

                <div class="form-group">

                    <label for="phone">Phone Number</label>
                    <input type="text" class="input" id="phone" name="phone" value="<?php echo htmlspecialchars($user["phone"]); ?>">

                    <span class="error-text">
                        <?php
                            if(isset($_GET["phoneErr"]))
                            {
                                echo htmlspecialchars($_GET["phoneErr"]);
                            }
                        ?>
                    </span>

                </div>

                <div class="form-actions">
                    <a href="profile.php" class="btn btn-secondary">Cancel</a>
                    <input type="submit" class="btn btn-primary" name="submit" value="Save Changes">
                </div>

            </form>

        </div>
    </div>
</body>

</html>

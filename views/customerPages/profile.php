<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION["userId"]) || $_SESSION["role"] != "customer") {
    header("Location: ../login.php");
    exit();
}

require_once "../../models/usersModel.php";

$activePage = "profile";
$user = getUserById($_SESSION["userId"]);

$wrapClass = "page-wrap";
$portalLabel = "Customer Portal";

?>

<!doctype html>
<html>

<head>
    <title>My Profile - DriveHub</title>
    <link rel="stylesheet" href="../css/profile.css">
    <script src="../js/index.js" defer></script>
</head>

<body>

    <div class="topnav">

        <div class="navleft">

            <div class="logo">
                <div class="logo-emoji">&#128663;</div>
                <div class="logo-text">DRIVE<span>HUB</span></div>
            </div>

            <div class="navlinks">

                <a href="vehicles.php" >Vehicles</a>
                <a href="customerDashboard.php">My Dashboard</a>
                <a href="profile.php" class="active">Profile</a>

            </div>

        </div>

        <div class="navright">

            <div class="user-block">

                <div class="username">
                    <?php echo htmlspecialchars($_SESSION["name"]); ?>
                </div>

                <div class="userrole">
                    Customer
                </div>

            </div>

            <a href="../logout.php" class="btn btn-secondary btn-small" style="color: black; background-color:salmon;">Logout</a>

        </div>

    </div>

    <div class="<?php echo $wrapClass; ?>">

        <div class="eyebrow"><?php echo $portalLabel; ?></div>
        <h1 class="page-title">My Profile</h1>
        <p class="page-subtitle">Your account details.</p>

        <?php
        if (isset($_GET["success"]) && $_GET["success"] != "") {
            echo '<div class="alert alert-success">' . htmlspecialchars($_GET["success"]) . '</div>';
        }

        if (isset($_GET["formErr"]) && $_GET["formErr"] != "") {
            echo '<div class="alert alert-error">' . htmlspecialchars($_GET["formErr"]) . '</div>';
        }
        ?>

        <div class="card" style="max-width: 820px;">

            <div class="sidebar-user" style="border-top: none; margin-top: 0; padding-top: 0;">

                <div>
                    <div class="card-title"><?php echo htmlspecialchars($user["name"]); ?></div>
                    <span class="badge badge-<?php echo $user["role"]; ?>"><?php echo ucfirst($user["role"]); ?></span>
                </div>

            </div>

            <div class="detail-row">
                <span class="key">Email</span>
                <span class="value"><?php echo htmlspecialchars($user["email"]); ?></span>
            </div>

            <div class="detail-row">
                <span class="key">Phone</span>
                <span class="value"><?php echo htmlspecialchars($user["phone"]); ?></span>
            </div>

            <div class="detail-row">
                <span class="key">Role</span>
                <span class="value"><?php echo ucfirst($user["role"]); ?></span>
            </div>

            <div class="detail-row">
                <span class="key">Account Status</span>
                <span class="value"><?php echo ucfirst($user["account_status"]); ?></span>
            </div>

            <div class="action-group" style="margin-top: 26px;">

                <a href="editProfile.php" class="btn btn-primary">Edit Profile</a>
                <a href="changePassword.php" class="btn btn-ghost">Change Password</a>
                <a href="../../controllers/accountControls.php?action=deleteAccount" class="btn btn-danger" onclick="return confirmDelete('your own account')">Delete Account</a>

            </div>

        </div>

    </div>

</body>

</html>
<?php
session_start();
if(isset($_SESSION["userId"]) && isset($_SESSION["role"]))
{
    if($_SESSION["role"]=="employee")
    {
        
    }
    else
    {
        header("Location: ../login.php");
        exit;
    }
}
else
{
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/employeeStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="../js/employeeScript.js" defer></script>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <div class="logo-icon"><i class="fa-solid fa-car"></i></div>
            <span class="logo-text">DRIVE<span class="logo-hub">HUB</span></span>
        </div>

        <div class="user-profile">
            <div class="user-info">
                <span class="user-role-badge">&#9679; Employee</span>
            </div>
        </div>

        <hr class="sidebar-divider">

        <nav class="nav-menu">
            <a class="nav-item" href="overview.php">
                <span class="nav-icon"><i class="fa-solid fa-table-cells-large"></i></span> Overview
            </a>
            <a class="nav-item" href="inquiries.php">
                <span class="nav-icon"><i class="fa-solid fa-comments"></i></span> Customer Inquiries
            </a>
            <a class="nav-item" href="test_drive_schedule.php">
                <span class="nav-icon"><i class="fa-solid fa-calendar-days"></i></span> Test Drive Schedule
            </a>
            <a class="nav-item" href="sales_transactions.php">
                <span class="nav-icon"><i class="fa-solid fa-dollar-sign"></i></span> Sales Transactions
            </a>
            <a class="nav-item active" href="profile.php">
                <span class="nav-icon"><i class="fa-solid fa-user"></i></span> Profile
            </a>
        </nav>

        <hr class="sidebar-divider bottom-divider">
        <a class="nav-item logout-btn" href="../logout.php">
            <span class="nav-icon"><i class="fa-solid fa-right-from-bracket"></i></span> Logout
        </a>
    </div>

    <div class="main-content">
        <span class="kicker">STAFF WORKSPACE</span>
        <h1 class="page-title">Employee Operations</h1>

        <?php
        require_once "../../models/employeeModel.php";
        $userId = $_SESSION["userId"];
        $profile = getProfile($userId);
        
        $name = htmlspecialchars($profile['name']);
        $email = htmlspecialchars($profile['email']);
        $phone = htmlspecialchars($profile['phone']);
        $role = htmlspecialchars($profile['role']);
        $status = htmlspecialchars($profile['status']);
        ?>
        <div class="profile-card">
            <?php
            if(isset($_GET['msg'])) {
                if($_GET['msg'] == 'profile_updated') echo "<p style='color: green; margin-bottom:15px;'>Profile updated successfully!</p>";
                if($_GET['msg'] == 'password_updated') echo "<p style='color: green; margin-bottom:15px;'>Password changed successfully!</p>";
            }
            ?>
            <div class="profile-header">
                <div class="profile-info">
                    <h2 class="profile-name"><?php echo $name; ?></h2>
                    <span class="profile-badge">&#9679; <?php echo $role; ?></span>
                </div>
            </div>

            <hr class="profile-divider">

            <div class="profile-row">
                <span class="profile-label">Email</span>
                <span class="profile-value"><?php echo $email; ?></span>
            </div>
            <div class="profile-row">
                <span class="profile-label">Phone</span>
                <span class="profile-value"><?php echo $phone; ?></span>
            </div>
            <div class="profile-row">
                <span class="profile-label">Role</span>
                <span class="profile-value"><?php echo $role; ?></span>
            </div>
            <div class="profile-row">
                <span class="profile-label">Account Status</span>
                <span class="profile-value"><?php echo $status; ?></span>
            </div>

            <hr class="profile-divider">

            <div class="profile-actions">
                <a href="edit_profile.php" class="btn-edit" style="text-decoration:none; display:inline-block; text-align:center;">Edit Profile</a>
                <a href="change_password.php" class="btn-change-pass" style="text-decoration:none; display:inline-block; text-align:center;">Change Password</a>
                <a href="#" class="btn-delete" style="text-decoration:none; display:inline-block; text-align:center;">Delete Account</a>
            </div>
        </div>
    </div>
</body>
</html>

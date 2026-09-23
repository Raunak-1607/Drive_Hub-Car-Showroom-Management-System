<?php
session_start();

if(!isset($_SESSION["userId"]) || $_SESSION["role"]!="admin")
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <div class="logo-icon">&#128663;</div>
            <span class="logo-text">DRIVE<span class="logo-hub">HUB</span></span>
        </div>
        <div class="user-profile">
            <div class="avatar">AD</div>
            <div class="user-info">
                <span class="user-name">Admin User</span>
                <span class="user-role-badge">&#9679; Admin</span>
            </div>
        </div>
        <hr class="sidebar-divider">
        <nav class="nav-menu">
            <a class="nav-item" href="overview_admin.php">Dashboard</a>
            <a class="nav-item" href="vehicle_inventory.php">Vehicle Inventory</a>
            <a class="nav-item" href="employee_accounts.php">Employee Accounts</a>
            <a class="nav-item" href="showroom_reports.php">Showroom Reports</a>
            <a class="nav-item active" href="admin_profile.php">Profile</a>
        </nav>
        <hr class="sidebar-divider bottom-divider">
        <a class="nav-item logout-btn" href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <span class="kicker">ADMIN PANEL</span>
        <h1 class="page-title">Profile</h1>

        <?php
        require_once "../models/adminModel.php";
        $adminId = 1;
        $profile = getUserProfile($adminId);

        $name = htmlspecialchars($profile['name'] ?? 'Admin User');
        $email = htmlspecialchars($profile['email'] ?? 'admin@drivehub.com');
        $phone = htmlspecialchars($profile['phone'] ?? '');
        $status = htmlspecialchars(ucfirst($profile['account_status'] ?? 'active'));
        ?>

        <div class="profile-card">
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'profile_updated') echo "<p style='color:#22C55E; margin-bottom:15px;'>Profile updated successfully!</p>";
                if ($_GET['msg'] == 'password_updated') echo "<p style='color:#22C55E; margin-bottom:15px;'>Password changed successfully!</p>";
            }
            ?>
            <div class="profile-header">
                <div class="profile-avatar">AD</div>
                <div class="profile-info">
                    <h2 class="profile-name"><?php echo $name; ?></h2>
                    <span class="profile-badge">&#9679; Administrator</span>
                </div>
            </div>

            <hr class="profile-divider">

            <div class="profile-row"><span class="profile-label">Email</span><span class="profile-value"><?php echo $email; ?></span></div>
            <div class="profile-row"><span class="profile-label">Phone</span><span class="profile-value"><?php echo $phone; ?></span></div>
            <div class="profile-row"><span class="profile-label">Role</span><span class="profile-value">Administrator</span></div>
            <div class="profile-row"><span class="profile-label">Account Status</span><span class="profile-value"><?php echo $status; ?></span></div>

            <hr class="profile-divider">

            <div class="profile-actions">
                <a href="edit_admin_profile.php" class="btn-edit">Edit Profile</a>
                <a href="change_admin_password.php" class="btn-change-pass">Change Password</a>
            </div>
        </div>
    </div>
</body>
</html>

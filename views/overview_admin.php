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
            <a class="nav-item active" href="overview_admin.php">Dashboard</a>
            <a class="nav-item" href="vehicle_inventory.php">Vehicle Inventory</a>
            <a class="nav-item" href="employee_accounts.php">Employee Accounts</a>
            <a class="nav-item" href="showroom_reports.php">Showroom Reports</a>
            <a class="nav-item" href="admin_profile.php">Profile</a>
        </nav>
        <hr class="sidebar-divider bottom-divider">
        <a class="nav-item logout-btn" href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <span class="kicker">ADMIN PANEL</span>
        <h1 class="page-title">Management Dashboard</h1>

        <div class="cards-grid">
            <?php
            require_once "../models/adminModel.php";
            $stats = getShowroomReportStats();
            if (!empty($stats)) {
                echo "<div class='stat-card'><h2 class='stat-number' style='color:#F59E0B'>" . htmlspecialchars($stats['total_vehicles']) . "</h2><p class='stat-label'>Total Vehicles</p></div>";
                echo "<div class='stat-card'><h2 class='stat-number' style='color:#22C55E'>" . htmlspecialchars($stats['available_vehicles']) . "</h2><p class='stat-label'>Available Vehicles</p></div>";
                echo "<div class='stat-card'><h2 class='stat-number' style='color:#8B5CF6'>" . htmlspecialchars($stats['total_sales']) . "</h2><p class='stat-label'>Vehicles Sold</p></div>";
                echo "<div class='stat-card'><h2 class='stat-number' style='color:#3B82F6'>" . htmlspecialchars($stats['total_employees']) . "</h2><p class='stat-label'>Employees</p></div>";
            } else {
                echo "<p>No stats available.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

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
            <a class="nav-item active" href="employee_accounts.php">Employee Accounts</a>
            <a class="nav-item" href="showroom_reports.php">Showroom Reports</a>
            <a class="nav-item" href="admin_profile.php">Profile</a>
        </nav>
        <hr class="sidebar-divider bottom-divider">
        <a class="nav-item logout-btn" href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <span class="kicker">ADMIN PANEL</span>
        <h1 class="page-title">Edit Employee</h1>

        <div class="table-container" style="max-width:700px;">
            <?php
            require_once "../models/adminModel.php";
            $id = $_GET['id'] ?? '';
            $employees = getAllEmployees();
            $employee = null;
            foreach ($employees as $e) {
                if ($e['user_id'] == $id) { $employee = $e; break; }
            }

            if (isset($_GET['err']) && $_GET['err'] == 'empty_fields') {
                echo "<p style='color:#EF4444; margin-bottom:15px;'>Name and Email are required.</p>";
            }

            if (!$employee) {
                echo "<p>Employee not found.</p>";
            } else {
            ?>
            <form action="../controllers/adminController.php" method="POST">
                <input type="hidden" name="action" value="update_employee">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($employee['user_id']); ?>">
                <div class="form-row">
                    <div class="form-group full-width"><label>Name</label><input type="text" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required></div>
                    <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>"></div>
                </div>
                <div class="modal-actions">
                    <a class="btn-cancel" href="employee_accounts.php">Cancel</a>
                    <button type="submit" class="btn-save">Save Changes</button>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>

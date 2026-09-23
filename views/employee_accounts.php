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
        <h1 class="page-title">Employee Accounts</h1>

        <div class="table-container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">All Employees</h2>
                    <p class="section-subtitle">Create, edit, or remove employee accounts.</p>
                </div>
                <a class="btn-new-sale" href="add_employee.php">+ Add Employee</a>
            </div>

            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'employee_added') echo "<p style='color:#22C55E; margin-bottom:10px;'>Employee added successfully.</p>";
                if ($_GET['msg'] == 'employee_updated') echo "<p style='color:#22C55E; margin-bottom:10px;'>Employee updated successfully.</p>";
            }
            ?>

            <table>
                <tr><th>EMPLOYEE</th><th>EMAIL</th><th>PHONE</th><th>STATUS</th><th>ACTIONS</th></tr>
                <?php
                require_once "../models/adminModel.php";
                $employees = getAllEmployees();
                if (!empty($employees)) {
                    foreach ($employees as $e) {
                        echo "<tr>";
                        echo "<td class='customer-name'>" . htmlspecialchars($e['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($e['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($e['phone']) . "</td>";
                        $isActive = ($e['account_status'] === 'active');
                        $badgeClass = $isActive ? 'badge-approved' : 'badge-rejected';
                        echo "<td><span class='" . $badgeClass . "'>&#9679; " . htmlspecialchars(ucfirst($e['account_status'])) . "</span></td>";
                        echo "<td><div class='actions-cell'>";
                        echo "<a class='btn-view action-btn' href='edit_employee.php?id=" . urlencode($e['user_id']) . "'>Edit</a>";
                        if ($isActive) {
                            echo "<a class='btn-reject action-btn' href='../controllers/adminController.php?action=deactivate_employee&id=" . urlencode($e['user_id']) . "'>Deactivate</a>";
                        } else {
                            echo "<a class='btn-approve action-btn' href='../controllers/adminController.php?action=activate_employee&id=" . urlencode($e['user_id']) . "'>Activate</a>";
                        }
                        echo "<a class='btn-reject action-btn' href='../controllers/adminController.php?action=delete_employee&id=" . urlencode($e['user_id']) . "' onclick=\"return confirm('Delete this employee?');\">Delete</a>";
                        echo "</div></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No employees found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>

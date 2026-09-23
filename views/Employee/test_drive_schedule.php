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
            <a class="nav-item active" href="test_drive_schedule.php">
                <span class="nav-icon"><i class="fa-solid fa-calendar-days"></i></span> Test Drive Schedule
            </a>
            <a class="nav-item" href="sales_transactions.php">
                <span class="nav-icon"><i class="fa-solid fa-dollar-sign"></i></span> Sales Transactions
            </a>
            <a class="nav-item" href="profile.php">
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

        <div class="table-container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Test Drive Schedule</h2>
                    <p class="section-subtitle">Approve or reject customer test drive requests &mdash; Pending &rarr; Approved / Rejected</p>
                </div>
            </div>
            <table id="testDrivesTable">
                <tr>
                    <th>CUSTOMER</th>
                    <th>VEHICLE</th>
                    <th>REQUESTED DATE</th>
                    <th>REQUESTED TIME</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
                <?php
                require_once "../../models/employeeModel.php";
                $testDrivesData = getTestDrives();
                
                if (!empty($testDrivesData)) {
                    foreach ($testDrivesData as $drive) {
                        echo "<tr>";
                        echo "<td class='customer-name'>" . htmlspecialchars($drive['customer']) . "</td>";
                        echo "<td>" . htmlspecialchars($drive['vehicle']) . "</td>";
                        echo "<td>" . htmlspecialchars($drive['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($drive['time']) . "</td>";
                        
                        $badgeClass = 'badge-pending';
                        if ($drive['status'] === 'Approved') $badgeClass = 'badge-approved';
                        else if ($drive['status'] === 'Rejected') $badgeClass = 'badge-rejected';
                        
                        echo "<td><span class='" . $badgeClass . "'>&#9679; " . htmlspecialchars($drive['status']) . "</span></td>";
                        
                        echo "<td><div class='actions-cell'>";
                        if ($drive['status'] === 'Pending') {
                            echo "<button class='btn-approve action-btn' data-action='approve' data-id='" . htmlspecialchars($drive['id']) . "'>Approve</button>";
                            echo "<button class='btn-reject action-btn' data-action='reject' data-id='" . htmlspecialchars($drive['id']) . "'>Reject</button>";
                        }
                        echo "<a href='edit_test_drive.php?id=" . htmlspecialchars($drive['id']) . "' class='btn-view' style='margin-right: 5px; text-decoration:none; display:inline-block;'>Edit</a>";
                        echo "<a href='../controllers/testDriveController.php?action=delete&id=" . htmlspecialchars($drive['id']) . "' class='btn-reject' style='text-decoration:none; display:inline-block;'>Delete</a>";
                        echo "</div></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>

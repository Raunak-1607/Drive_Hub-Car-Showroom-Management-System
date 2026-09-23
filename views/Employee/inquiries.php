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
            <a class="nav-item active" href="inquiries.php">
                <span class="nav-icon"><i class="fa-solid fa-comments"></i></span> Customer Inquiries
            </a>
            <a class="nav-item" href="test_drive_schedule.php">
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
                    <h2 class="section-title">Customer Inquiries</h2>
                    <p class="section-subtitle">Review a customer's message, write a response, then mark it Resolved &mdash; Pending &rarr; Resolved</p>
                </div>
            </div>
            <table id="inquiriesTable">
                <tr>
                    <th>CUSTOMER</th>
                    <th>VEHICLE</th>
                    <th>MESSAGE</th>
                    <th>DATE</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
                <?php
                require_once "../../models/employeeModel.php";
                $inquiriesData = getInquiries();
                
                if (!empty($inquiriesData)) {
                    foreach ($inquiriesData as $inquiry) {
                        echo "<tr>";
                        echo "<td><div class='customer-cell'><span class='avatar-small' style='background-color:" . htmlspecialchars($inquiry['avatarColor']) . "'>" . htmlspecialchars($inquiry['initials']) . "</span><span class='customer-name'>" . htmlspecialchars($inquiry['customer']) . "</span></div></td>";
                        echo "<td>" . htmlspecialchars($inquiry['vehicle']) . "</td>";
                        echo "<td>" . htmlspecialchars($inquiry['message']) . "</td>";
                        echo "<td>" . htmlspecialchars($inquiry['date']) . "</td>";
                        
                        $badgeClass = ($inquiry['status'] === 'Resolved') ? 'badge-resolved' : 'badge-pending';
                        echo "<td><span class='" . $badgeClass . "'>&#9679; " . htmlspecialchars($inquiry['status']) . "</span></td>";
                        
                        echo "<td><div class='actions-cell'>";
                        echo "<a href='edit_inquiry.php?id=" . htmlspecialchars($inquiry['id']) . "' class='btn-view' style='margin-right: 5px;'>Edit</a>";
                        echo "<a href='../controllers/inquiryController.php?action=delete&id=" . htmlspecialchars($inquiry['id']) . "' class='btn-reject' style='text-decoration:none; display:inline-block;'>Delete</a>";
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

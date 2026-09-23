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
            <a class="nav-item active" href="sales_transactions.php">
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
                    <h2 class="section-title">Sales Transactions</h2>
                    <p class="section-subtitle">Create and process sales &mdash; Pending &rarr; Sold</p>
                </div>
                <a class="btn-new-sale" href="new_sale.php">+ New Sale</a>
            </div>
            <table id="salesTable">
                <tr>
                    <th>CUSTOMER</th>
                    <th>VEHICLE</th>
                    <th>SALE DATE</th>
                    <th>AMOUNT</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
                <?php
                require_once "../../models/employeeModel.php";
                $salesData = getSales();
                
                if (!empty($salesData)) {
                    foreach ($salesData as $sale) {
                        echo "<tr>";
                        echo "<td class='customer-name'>" . htmlspecialchars($sale['customer']) . "</td>";
                        
                        echo "<td><span>" . htmlspecialchars($sale['vehicle']) . "</span>";
                        if ($sale['vehicleSold']) {
                            echo "<span class='vehicle-sold-text'>Vehicle marked Sold</span>";
                        }
                        echo "</td>";
                        
                        echo "<td>" . htmlspecialchars($sale['saleDate']) . "</td>";
                        echo "<td><span class='amount-text'>" . htmlspecialchars($sale['amount']) . "</span></td>";
                        
                        $badgeClass = ($sale['status'] === 'Sold') ? 'badge-sold' : 'badge-pending';
                        echo "<td><span class='" . $badgeClass . "'>&#9679; " . htmlspecialchars($sale['status']) . "</span></td>";
                        
                        echo "<td><div class='actions-cell'>";
                        if ($sale['status'] === 'Pending') {
                            echo "<button class='btn-mark-sold action-btn' data-action='sold' data-id='" . htmlspecialchars($sale['id']) . "'>Mark Sold</button>";
                        }
                        echo "<a href='edit_sale.php?id=" . htmlspecialchars($sale['id']) . "' class='btn-view' style='margin-right: 5px; text-decoration:none; display:inline-block;'>Edit</a>";
                        echo "<a href='../controllers/salesController.php?action=delete&id=" . htmlspecialchars($sale['id']) . "' class='btn-reject' style='text-decoration:none; display:inline-block;'>Delete</a>";
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

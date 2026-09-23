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
    <?php
    require_once "../../models/employeeModel.php";
    $cars = getAvailableCars();
    ?>
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

        <div class="table-container" style="max-width:700px;">
            <h2 class="section-title">New Sale</h2>
            <p class="section-subtitle">Create a sales record.</p>
            <span style="color:red;">
                <?php
                if(isset($_GET['insertErr']))
                {
                    echo $_GET['insertErr'];
                }
                ?>
            </span>

            <form action="../../controllers/salesController.php" method="POST" id="newSaleForm" onsubmit="return validateNewSaleForm()">
                <input type="hidden" name="action" value="new_sale">
                <div class="form-row">
                <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" id="saleCustomer" name="customer" placeholder="Enter customer name">
                    <span id="customerErr" style="color:red;">
                        <?php
                        if(isset($_GET['customerErr']))
                        {
                            echo $_GET['customerErr'];
                        }
                        ?>
                    </span>
                </div>
                <div class="form-group">
                    <label>Vehicle (available only)</label>
                    <select id="saleVehicle" name="vehicle">
                        <option value="">Select a vehicle</option>
                        <?php
                        foreach($cars as $car)
                        {
                            $vehicleName = $car['brand'] . " " . $car['model'];
                            echo "<option value='".$vehicleName."'>".$vehicleName."</option>";
                        }
                        ?>
                    </select>
                    <span id="vehicleErr" style="color:red;">
                        <?php
                        if(isset($_GET['vehicleErr']))
                        {
                            echo $_GET['vehicleErr'];
                        }
                        ?>
                    </span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Sale Price</label>
                    <div class="input-with-suffix">
                        <input type="text" id="salePrice" name="salePrice" value="112000">
                        <span class="input-suffix">USD</span>
                    </div>
                    <span id="salePriceErr" style="color:red;">
                        <?php
                        if(isset($_GET['salePriceErr']))
                        {
                            echo $_GET['salePriceErr'];
                        }
                        ?>
                    </span>
                </div>
                <div class="form-group">
                    <label>Sale Date</label>
                    <input type="date" id="saleDate" name="saleDate">
                    <span id="saleDateErr" style="color:red;">
                        <?php
                        if(isset($_GET['saleDateErr']))
                        {
                            echo $_GET['saleDateErr'];
                        }
                        ?>
                    </span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label>Status</label>
                    <select id="saleStatus" name="saleStatus">
                        <option value="Pending">Pending</option>
                        <option value="Sold">Sold</option>
                    </select>
                </div>
            </div>

            <div class="modal-actions">
                <a class="btn-cancel" href="sales_transactions.php">Cancel</a>
                <button type="submit" class="btn-save">Save Sale</button>
            </div>
            </form>
        </div>
    </div>
</body>

</html>

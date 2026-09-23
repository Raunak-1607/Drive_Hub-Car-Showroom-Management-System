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
        <span class="kicker">SALES MANAGEMENT</span>
        <h1 class="page-title">Edit Sale</h1>
        <p class="section-subtitle">Update sale details below.</p>

        <?php
        require_once "../../models/employeeModel.php";
        
        $id = "";
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
        }
        if(!$id)
        {
            echo "<p>Invalid sale ID.</p>";
            exit;
        }

        $sale = getSale($id);
        if(!$sale)
        {
            echo "<p>Sale not found.</p>";
            exit;
        }
        ?>

        <div class="table-container">
            <form action="../../controllers/salesController.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($sale['id']); ?>">
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Customer</label>
                        <input type="text" name="customer" value="<?php echo htmlspecialchars($sale['customer']); ?>">
                        <span class="error-msg">
                            <?php
                            if(isset($_GET['customerErr']))
                            {
                                echo $_GET['customerErr'];
                            }
                            ?>
                        </span>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Vehicle</label>
                        <input type="text" name="vehicle" value="<?php echo htmlspecialchars($sale['vehicle']); ?>">
                        <span class="error-msg">
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
                    <div class="form-group full-width">
                        <label>Date</label>
                        <input type="date" name="saleDate" value="<?php echo htmlspecialchars($sale['saleDate']); ?>">
                        <span class="error-msg">
                            <?php
                            if(isset($_GET['dateErr']))
                            {
                                echo $_GET['dateErr'];
                            }
                            ?>
                        </span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Amount ($)</label>
                        <input type="text" name="amount" value="<?php echo htmlspecialchars($sale['amount']); ?>">
                        <span class="error-msg">
                            <?php
                            if(isset($_GET['amountErr']))
                            {
                                echo $_GET['amountErr'];
                            }
                            ?>
                        </span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Status</label>
                        <select name="status">
                            <option value="Pending" <?php if(strtolower($sale['status']) == 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="Sold" <?php if(strtolower($sale['status']) == 'sold') echo 'selected'; ?>>Sold</option>
                            <option value="Cancelled" <?php if(strtolower($sale['status']) == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn-save">Update Sale</button>
                    <a href="sales_transactions.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

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
        <span class="kicker">TEST DRIVE MANAGEMENT</span>
        <h1 class="page-title">Edit Test Drive</h1>
        <p class="section-subtitle">Update test drive details below.</p>

        <?php
        require_once "../../models/employeeModel.php";
        
        $id = "";
        if(isset($_GET['id'])) $id = $_GET['id'];
        if(!$id) {
            echo "<p>Invalid test drive ID.</p>";
            exit;
        }

        $drive = getTestDrive($id);
        if(!$drive) {
            echo "<p>Test drive not found.</p>";
            exit;
        }
        ?>

        <div class="table-container" style="padding: 2.083vw;">
            <form action="../../controllers/testDriveController.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($drive['id']); ?>">
                
                <div style="margin-bottom: 1.042vw;">
                    <label style="display:block; color: #a1a1aa; margin-bottom: 0.521vw;">Customer</label>
                    <input type="text" value="<?php echo htmlspecialchars($drive['customer']); ?>" disabled style="width: 100%; padding: 0.521vw; background: #27272a; border: 1px solid #3f3f46; color: white; border-radius: 0.26vw;">
                </div>
                
                <div style="margin-bottom: 1.042vw;">
                    <label style="display:block; color: #a1a1aa; margin-bottom: 0.521vw;">Vehicle</label>
                    <input type="text" value="<?php echo htmlspecialchars($drive['vehicle']); ?>" disabled style="width: 100%; padding: 0.521vw; background: #27272a; border: 1px solid #3f3f46; color: white; border-radius: 0.26vw;">
                </div>

                <div style="margin-bottom: 1.042vw;">
                    <label style="display:block; color: #a1a1aa; margin-bottom: 0.521vw;">Date</label>
                    <input type="date" name="date" value="<?php echo htmlspecialchars($drive['date']); ?>" style="width: 100%; padding: 0.521vw; background: #27272a; border: 1px solid #3f3f46; color: white; border-radius: 0.26vw;">
                    <span style="color:red;"><?php if(isset($_GET['dateErr'])) echo $_GET['dateErr']; ?></span>
                </div>

                <div style="margin-bottom: 1.042vw;">
                    <label style="display:block; color: #a1a1aa; margin-bottom: 0.521vw;">Time</label>
                    <input type="time" name="time" value="<?php echo htmlspecialchars($drive['time']); ?>" style="width: 100%; padding: 0.521vw; background: #27272a; border: 1px solid #3f3f46; color: white; border-radius: 0.26vw;">
                    <span style="color:red;"><?php if(isset($_GET['timeErr'])) echo $_GET['timeErr']; ?></span>
                </div>

                <div style="margin-bottom: 1.042vw;">
                    <label style="display:block; color: #a1a1aa; margin-bottom: 0.521vw;">Status</label>
                    <select name="status" style="width: 100%; padding: 0.521vw; background: #27272a; border: 1px solid #3f3f46; color: white; border-radius: 0.26vw;">
                        <option value="Pending" <?php if(strtolower($drive['status']) == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="Approved" <?php if(strtolower($drive['status']) == 'approved') echo 'selected'; ?>>Approved</option>
                        <option value="Rejected" <?php if(strtolower($drive['status']) == 'rejected') echo 'selected'; ?>>Rejected</option>
                        <option value="Completed" <?php if(strtolower($drive['status']) == 'completed') echo 'selected'; ?>>Completed</option>
                    </select>
                </div>

                <div style="margin-top: 1.042vw;">
                    <button type="submit" class="btn-approve" style="border: none; padding: 0.521vw 1.042vw; border-radius: 0.26vw; cursor: pointer; color: black; font-weight: bold;">Update Test Drive</button>
                    <a href="test_drive_schedule.php" class="btn-view" style="text-decoration:none; display:inline-block;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

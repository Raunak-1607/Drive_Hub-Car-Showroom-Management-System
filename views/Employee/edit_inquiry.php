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
        <h1 class="page-title">Edit Inquiry</h1>

        <div class="profile-card">
            <?php
            require_once "../../models/employeeModel.php";
            $id = "";
            if(isset($_GET['id'])) $id = $_GET['id'];
            $inquiry = null;
            if ($id) {
                $inquiry = getInquiry($id);
            }
            if (!$inquiry) {
                echo "<p style='color:red;'>Inquiry not found.</p>";
            } else {
            ?>
            <form action="../../controllers/inquiryController.php?action=update&id=<?php echo htmlspecialchars($id); ?>" method="POST">
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label>Message</label>
                    <textarea name="message"><?php echo htmlspecialchars($inquiry['message']); ?></textarea>
                    <span style="color:red;"><?php if(isset($_GET['messageErr'])) echo $_GET['messageErr']; ?></span>
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label>Status</label>
                    <select name="status">
                        <option value="pending" <?php if($inquiry['inquiry_status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="resolved" <?php if($inquiry['inquiry_status'] == 'resolved') echo 'selected'; ?>>Resolved</option>
                    </select>
                </div>
                
                <hr class="profile-divider">

                <div style="margin-top: 1.042vw;">
                    <button type="submit" class="btn-submit" style="background-color: rgb(245, 158, 11); color: black; border: none; padding: 1.111vh 1.389vw; border-radius: 0.556vw; font-weight: bold; cursor: pointer;">Update Inquiry</button>
                    <a href="inquiries.php" class="btn-cancel" style="background: none; border: 1px solid rgb(63, 63, 70); color: white; padding: 1.111vh 1.389vw; border-radius: 0.556vw; text-decoration: none; display: inline-block;">Cancel</a>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</body>

</html>

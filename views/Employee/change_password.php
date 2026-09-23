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
    <style>
        .form-group {
             margin-bottom: 1.667vh; 
            
        }
        .form-group label { 
            display: block; 
            margin-bottom: 0.556vh; 
            color: rgb(161, 161, 170); 
        }
        .form-group input { 
            width: 100%; 
            padding: 0.694vw; 
            background: rgb(39, 39, 42);
            border: 1px solid rgb(63, 63, 70); 
            color: white; 
            border-radius: 0.278vw; }
        .btn-submit { 
            background: rgb(14, 165, 233); 
            color: rgb(255, 255, 255); 
            padding: 1.111vh 1.042vw; 
            border: none; 
            border-radius: 0.278vw; 
            cursor: pointer; 
            font-weight: bold; 
        }
        .btn-cancel { 
            background: rgb(63, 63, 70); 
            color: rgb(255, 255, 255); 
            padding: 1.111vh 1.042vw; 
            border: none; 
            border-radius: 0.278vw;
             cursor: pointer; 
             text-decoration: none; 
             display: inline-block; 
        }
    </style>
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
            <a class="nav-item" href="sales_transactions.php">
                <span class="nav-icon"><i class="fa-solid fa-dollar-sign"></i></span> Sales Transactions
            </a>
            <a class="nav-item active" href="profile.php">
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
        <h1 class="page-title">Change Password</h1>

        <div class="profile-card">
            <?php
            if(isset($_GET['msg']) && $_GET['msg'] == 'password_updated') {
                echo "<p style='color: green; margin-bottom:15px;'>Password updated successfully.</p>";
            }
            ?>
            <form action="../../controllers/profileController.php" method="POST">
                <input type="hidden" name="action" value="change_password">
                
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password">
                    <span style="color: red; font-size: 12px;">
                        <?php
                        if(isset($_GET["currentPassErr"])) {
                            echo $_GET["currentPassErr"];
                        }
                        ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password">
                    <span style="color: red; font-size: 12px;">
                        <?php
                        if(isset($_GET["newPassErr"])) {
                            echo $_GET["newPassErr"];
                        }
                        ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password">
                    <span style="color: red; font-size: 12px;">
                        <?php
                        if(isset($_GET["confirmPassErr"])) {
                            echo $_GET["confirmPassErr"];
                        }
                        ?>
                    </span>
                </div>

                <hr class="profile-divider">

                <div style="margin-top: 1.042vw;">
                    <button type="submit" class="btn-submit">Update Password</button>
                    <a href="profile.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

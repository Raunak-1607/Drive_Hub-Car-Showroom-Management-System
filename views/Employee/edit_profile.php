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
        .form-group { margin-bottom: 1.667vh; }
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
               border-radius: 0.278vw; 
            }
        .btn-submit { 
               background: rgb(245, 158, 11); 
               color: rgb(0, 0, 0);
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
        <h1 class="page-title">Edit Profile</h1>

        <?php
        require_once "../../models/employeeModel.php";
        $userId = $_SESSION["userId"];
        $profile = getProfile($userId);
        
        $name = htmlspecialchars($profile['name']);
        $email = htmlspecialchars($profile['email']);
        $phone = htmlspecialchars($profile['phone']);
        ?>

        <div class="profile-card">
            <?php
            if(isset($_GET['msg']) && $_GET['msg'] == 'profile_updated') {
                echo "<p style='color: green; margin-bottom:15px;'>Profile updated successfully.</p>";
            }
            ?>
            <form action="../../controllers/profileController.php" method="POST">
                <input type="hidden" name="action" value="edit_profile">
                
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $name; ?>">
                    <span style="color: red; font-size: 12px;">
                        <?php
                        if(isset($_GET["nameErr"])) {
                            echo $_GET["nameErr"];
                        }
                        ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $email; ?>">
                    <span style="color: red; font-size: 12px;">
                        <?php
                        if(isset($_GET["emailErr"])) {
                            echo $_GET["emailErr"];
                        }
                        ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $phone; ?>">
                </div>

                <hr class="profile-divider">

                <div style="margin-top: 1.042vw;">
                    <button type="submit" class="btn-submit">Save Changes</button>
                    <a href="profile.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

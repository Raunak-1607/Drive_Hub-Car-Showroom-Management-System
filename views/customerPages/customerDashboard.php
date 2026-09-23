<?php

session_start();

if (!isset($_SESSION["userId"]) || $_SESSION["role"] != "customer") {
    header("Location: ../login.php");
    exit();
}

require_once "../../models/testDrivesModel.php";
require_once "../../models/inquiriesModel.php";

$activePage = "dashboard";

$testDrives = getTestDrivesByCustomer($_SESSION["userId"]);
$inquiries = getInquiriesByCustomer($_SESSION["userId"]);

?>

<!doctype html>
<html>

<head>
    <title>My Dashboard - DriveHub</title>
    <link rel="stylesheet" href="../css/customerDashboard.css">
</head>

<body>

    <div class="topnav">

        <div class="navleft">

            <div class="logo">
                <div class="logo-emoji">&#128663;</div>
                <div class="logo-text">DRIVE<span>HUB</span></div>
            </div>

            <div class="navlinks">

                <a href="vehicles.php" >Vehicles</a>
                <a href="customerDashboard.php" class="active">My Dashboard</a>
                <a href="profile.php">Profile</a>

            </div>

        </div>

        <div class="navright">

            <div class="user-block">

                <div class="username">
                    <?php echo htmlspecialchars($_SESSION["name"]); ?>
                </div>

                <div class="userrole">
                    Customer
                </div>

            </div>

            <a href="../logout.php" class="btn btn-secondary btn-small" style="color: black; background-color:salmon;">Logout</a>

        </div>

    </div>

    <div class="page-wrap">

        <div class="eyebrow">Customer Portal</div>
        <h1 class="page-title">My Dashboard</h1>

        <p class="page-subtitle">
            Welcome back, <strong><?php echo htmlspecialchars($_SESSION["name"]); ?></strong>. Here's your activity overview.
        </p>

        <?php
        if (isset($_GET["success"]) && $_GET["success"] != "") {
            echo '<div class="alert alert-success">' . htmlspecialchars($_GET["success"]) . '</div>';
        }
        ?>

        <div class="stat-grid">

            <div class="stat-card">
                <div class="stat-number amber"><?php echo count($testDrives); ?></div>
                <div class="stat-label">Test Drive Requests</div>
            </div>

            <div class="stat-card">
                <div class="stat-number sky"><?php echo count($inquiries); ?></div>
                <div class="stat-label">Vehicle Inquiries</div>
            </div>

            <div class="stat-card">
                <div class="stat-number purple"><?php echo count($testDrives) + count($inquiries); ?></div>
                <div class="stat-label">Recent Activity</div>
            </div>

        </div>

        <div class="card">

            <div class="card-head">

                <div>
                    <div class="card-title">Test Drive Requests</div>
                    <div class="card-note">Track the status of your submitted requests &mdash; Pending &rarr; Approved / Rejected</div>
                </div>

                <a href="vehicles.php" class="btn btn-testdrive btn-small">+ New Request</a>

            </div>

            <table class="table">

                <tr>
                    <th>Vehicle</th>
                    <th>Requested Date</th>
                    <th>Preferred Time</th>
                    <th>Status</th>
                </tr>

                <?php
                if (count($testDrives) == 0) {
                    echo '<tr><td colspan="4" class="empty-row">You have not requested any test drives yet.</td></tr>';
                }

                foreach ($testDrives as $testDrive) {
                ?>
                    <tr>
                        <td class="strong"><?php echo htmlspecialchars($testDrive["brand"] . " " . $testDrive["model"]); ?></td>
                        <td><?php echo htmlspecialchars($testDrive["preferred_date"]); ?></td>
                        <td><?php echo date("h:i A", strtotime($testDrive["preferred_time"])); ?></td>
                        <td><span class="badge badge-<?php echo $testDrive["status"]; ?>"><?php echo ucfirst($testDrive["status"]); ?></span></td>
                    </tr>
                <?php
                }
                ?>

            </table>

        </div>

        <div class="card">

            <div class="card-head">

                <div>
                    <div class="card-title">Vehicle Inquiries</div>
                    <div class="card-note">Status and history of your inquiries &mdash; Pending &rarr; Resolved</div>
                </div>

            </div>

            <table class="table">

                <tr>
                    <th>Vehicle</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php
                if (count($inquiries) == 0) {
                    echo '<tr><td colspan="5" class="empty-row">You have not sent any inquiries yet.</td></tr>';
                }

                foreach ($inquiries as $inquiry) {
                    $shortMessage = $inquiry["message"];

                    if (strlen($shortMessage) > 60) {
                        $shortMessage = substr($shortMessage, 0, 60) . "...";
                    }
                ?>
                    <tr>
                        <td class="strong"><?php echo htmlspecialchars($inquiry["brand"] . " " . $inquiry["model"]); ?></td>
                        <td><?php echo htmlspecialchars($shortMessage); ?></td>
                        <td><?php echo date("Y-m-d", strtotime($inquiry["inquiry_date"])); ?></td>
                        <td><span class="badge badge-<?php echo $inquiry["inquiry_status"]; ?>"><?php echo ucfirst($inquiry["inquiry_status"]); ?></span></td>
                        <td><a href="inquiryDetails.php?inquiryId=<?php echo $inquiry["inquiry_id"]; ?>">View Details &rarr;</a></td>
                    </tr>

                <?php
                }
                ?>

            </table>

        </div>

    </div>
    
</body>

</html>
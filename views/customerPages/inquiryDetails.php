<?php

session_start();

if(!isset($_SESSION["userId"]) || $_SESSION["role"]!="customer")
{
    header("Location: ../login.php");
    exit();
}

require_once "../../models/inquiriesModel.php";

$activePage="dashboard";

if(!isset($_GET["inquiryId"]))
{
    header("Location: customerDashboard.php");
    exit();
}

$inquiry=getInquiryById($_GET["inquiryId"]);

if(!$inquiry || $inquiry["customer_id"]!=$_SESSION["userId"])
{
    header("Location: customerDashboard.php");
    exit();
}
?>
<!doctype html>
<html>

<head>
    <title>Inquiry Details - DriveHub</title>
    <link rel="stylesheet" href="../css/inquiryDetails.css">
</head>

<body>

    <div class="page-wrap">

        <div class="modal-card modal-center">

            <div class="modal-head">
                
                <div>
                    <div class="modal-title">Inquiry Details</div>

                    <div class="modal-note">
                        <?php echo htmlspecialchars($inquiry["brand"]." ".$inquiry["model"]); ?> &middot;
                        Submitted <?php echo date("Y-m-d", strtotime($inquiry["inquiry_date"])); ?>
                    </div>

                </div>

                <span class="badge badge-<?php echo $inquiry["inquiry_status"]; ?>"><?php echo ucfirst($inquiry["inquiry_status"]); ?></span>

            </div>

            <div class="read-label">Your Message</div>
            <div class="read-box"><?php echo nl2br(htmlspecialchars($inquiry["message"])); ?></div>

            <div class="read-label">Employee Response</div>
            
            <?php
                if($inquiry["employee_response"]!=null && trim($inquiry["employee_response"])!="")
                {
                    echo '<div class="read-box read-box-amber">'.nl2br(htmlspecialchars($inquiry["employee_response"])).'</div>';
                }
                else
                {
                    echo '<div class="read-box">No response yet. An employee will reply soon.</div>';
                }
            ?>

            <div class="form-actions">
                <a href="customerDashboard.php" class="btn btn-primary">Close</a>
            </div>

        </div>
    </div>
</body>

</html>

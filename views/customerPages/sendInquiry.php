<?php

session_start();

if(!isset($_SESSION["userId"]) || $_SESSION["role"]!="customer")
{
    header("Location: ../login.php");
    exit();
}

require_once "../../models/carsModel.php";

$activePage="vehicles";

if(!isset($_GET["carId"]))
{
    header("Location: vehicles.php");
    exit();
}

$car=getCarById($_GET["carId"]);

if(!$car)
{
    header("Location: vehicles.php");
    exit();
}

?>

<!doctype html>
<html>

<head>
    <title>Send an Inquiry - DriveHub</title>
    <link rel="stylesheet" href="../css/sendInquiry.css">
</head>

<body>

<div class="topnav">

    <div class="navleft">

        <div class="logo">
            <div class="logo-emoji">&#128663;</div>
            <div class="logo-text">DRIVE<span>HUB</span></div>
        </div>

        <div class="navlinks">
 
            <a href="vehicles.php" class="active">Vehicles</a>
            <a href="customerDashboard.php">My Dashboard</a>
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

        <div class="modal-card modal-center">

            <div class="modal-head">

                <div>
                    <div class="modal-title">Send an Inquiry</div>

                    <div class="modal-note">
                        Ask a question about this vehicle. An employee will respond and you'll see it on your dashboard.
                    </div>

                </div>

                <a href="carDetails.php?carId=<?php echo $car["car_id"]; ?>" class="modal-close">&times;</a>

            </div>

            <form action="../../controllers/inquiryControls.php?action=send" method="post">

                <input type="hidden" name="carId" value="<?php echo $car["car_id"]; ?>">

                <div class="form-group">
                    <label>Vehicle</label>
                    <div class="input-readonly"><?php echo htmlspecialchars($car["brand"]." ".$car["model"]); ?></div>
                </div>

                <div class="form-group">

                    <label for="message">Your Message</label>
                    <textarea class="textarea" id="message" name="message" placeholder="Type your question about pricing, availability, financing, specifications..."></textarea>

                    <span class="error-text">
                        <?php
                            if(isset($_GET["messageErr"]))
                            {
                                echo htmlspecialchars($_GET["messageErr"]);
                            }
                        ?>
                    </span>

                </div>

                <div class="form-actions">
                    <a href="carDetails.php?carId=<?php echo $car["car_id"]; ?>" class="btn btn-secondary">Cancel</a>
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit Inquiry">
                </div>

            </form>

        </div>
    </div>
</body>

</html>

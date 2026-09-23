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

    if(!$car || $car["availability_status"]=="sold")
    {
        header("Location: vehicles.php");
        exit();
    }

?>

<!doctype html>
<html>

<head>
    <title>Request a Test Drive - DriveHub</title>
    <link rel="stylesheet" href="../css/requestTestDrive.css">
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

                    <div class="modal-title">Request a Test Drive</div>

                    <div class="modal-note">
                        Pick a date and time. Your request stays <span class="amber">Pending</span>
                        until an employee approves or rejects it.
                    </div>

                </div>

                <a href="carDetails.php?carId=<?php echo $car["car_id"]; ?>" class="modal-close">&times;</a>

            </div>

            <form action="../../controllers/testDriveControls.php?action=request" method="post">

                <input type="hidden" name="carId" value="<?php echo $car["car_id"]; ?>">

                <div class="form-group">
                    <label>Vehicle</label>
                    <div class="input-readonly"><?php echo htmlspecialchars($car["brand"]." ".$car["model"]); ?></div>
                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label for="preferredDate">Preferred Date</label>
                        <input type="date" class="input" id="preferredDate" name="preferredDate">

                        <span class="error-text">
                            <?php
                                if(isset($_GET["dateErr"]))
                                {
                                    echo htmlspecialchars($_GET["dateErr"]);
                                }
                            ?>
                        </span>

                    </div>

                    <div class="form-group">

                        <label for="preferredTime">Preferred Time</label>

                        <select class="select" id="preferredTime" name="preferredTime">
                            <option value="">Select a time</option>
                            <option value="10:00:00">10:00 AM</option>
                            <option value="11:00:00">11:00 AM</option>
                            <option value="12:00:00">12:00 PM</option>
                            <option value="14:30:00">02:30 PM</option>
                            <option value="15:00:00">03:00 PM</option>
                            <option value="16:30:00">04:30 PM</option>
                        </select>

                        <span class="error-text">
                            <?php
                                if(isset($_GET["timeErr"]))
                                {
                                    echo htmlspecialchars($_GET["timeErr"]);
                                }
                            ?>
                        </span>

                    </div>
                </div>

                <div class="form-actions">
                    <a href="carDetails.php?carId=<?php echo $car["car_id"]; ?>" class="btn btn-secondary">Cancel</a>
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit Request">
                </div>

            </form>

        </div>
    </div>
</body>

</html>

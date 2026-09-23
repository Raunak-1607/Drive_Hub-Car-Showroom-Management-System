<?php

    session_start();

    if(!isset($_SESSION["userId"]) || $_SESSION["role"]!="customer")
    {
        header("Location: ../login.php");
        exit();
    }

    require_once "../../models/carsModel.php";

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
    <title>Car Details - DriveHub</title>
    <link rel="stylesheet" href="../css/carDetails.css">
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

        <div class="details-layout">

            <div class="details-photo">

                <?php
                    if($car["image"]!="")
                    {
                        echo '<img src="../images/'.htmlspecialchars($car["image"]).'" alt="'.htmlspecialchars($car["model"]).'">';
                    }
                    else
                    {
                        echo '<div class="car-icon car-icon-large"></div>';
                    }
                ?>

            </div>

            <div>

                <div class="details-top">

                    <div class="car-brand"><?php echo htmlspecialchars($car["brand"]); ?></div>

                </div>

                <div class="details-model"><?php echo htmlspecialchars($car["model"]); ?></div>
                <div class="car-year"><?php echo htmlspecialchars($car["year"]); ?></div>

                <div class="price-tag">Starting Price</div>
                <div class="price-big">$<?php echo number_format($car["price"]); ?></div>

                <div class="details-grid">

                    <div class="spec-box">
                        <div class="spec-label">Brand</div>
                        <div class="spec-value"><?php echo htmlspecialchars($car["brand"]); ?></div>
                    </div>

                    <div class="spec-box">
                        <div class="spec-label">Model</div>
                        <div class="spec-value"><?php echo htmlspecialchars($car["model"]); ?></div>
                    </div>

                    <div class="spec-box">
                        <div class="spec-label">Year</div>
                        <div class="spec-value"><?php echo htmlspecialchars($car["year"]); ?></div>
                    </div>

                    <div class="spec-box">
                        <div class="spec-label">Price</div>
                        <div class="spec-value">$<?php echo number_format($car["price"]); ?></div>
                    </div>

                    <div class="spec-box">
                        <div class="spec-label">Fuel Type</div>
                        <div class="spec-value"><?php echo htmlspecialchars($car["fuel_type"]); ?></div>
                    </div>

                    <div class="spec-box">
                        <div class="spec-label">Transmission</div>
                        <div class="spec-value"><?php echo htmlspecialchars($car["transmission"]); ?></div>
                    </div>

                    <div class="spec-box">
                        <div class="spec-label">Engine</div>
                        <div class="spec-value"><?php echo htmlspecialchars($car["engine"]); ?></div>
                    </div>

                    <div class="spec-box">
                        <div class="spec-label">Availability</div>
                        <div class="spec-value"><?php echo ucfirst($car["availability_status"]); ?></div>
                    </div>

                </div>

                <div class="details-cta">
                    <?php
                        if($car["availability_status"]=="available")
                        {
                            echo '<a href="requestTestDrive.php?carId='.$car["car_id"].'" class="btn btn-testdrive">Request Test Drive</a>';
                        }
                        else
                        {
                            echo '<span class="btn btn-secondary">Test Drive Unavailable</span>';
                        }
                    ?>

                    <a href="sendInquiry.php?carId=<?php echo $car["car_id"]; ?>" class="btn btn-ghost">Send Inquiry</a>

                </div>
            </div>

        </div>

    </div>
</body>

</html>

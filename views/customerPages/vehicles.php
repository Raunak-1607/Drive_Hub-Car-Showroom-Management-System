<?php

    session_start();

    if(!isset($_SESSION["userId"]) || $_SESSION["role"]!="customer")
    {
        header("Location: ../login.php");
        exit();
    }

    require_once "../../models/carsModel.php";

    $keyword="";
    $availability="";
    $sort="priceLow";

    if(isset($_GET["keyword"]))
    {
        $keyword=trim($_GET["keyword"]);
    }

    if(isset($_GET["availability"]))
    {
        $availability=$_GET["availability"];
    }

    if(isset($_GET["sort"]))
    {
        $sort=$_GET["sort"];
    }

    $cars=getCars($keyword, $availability, $sort);

?>

<!doctype html>
<html>

<head>

    <title>Vehicles - DriveHub</title>

    <link rel="stylesheet" href="../css/vehicles.css">

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



    <div class="container">

        <div class="page-tag"><b>DRIVEHUB COLLECTION</b></div>

        <h1 class="page-title">Explore Our Vehicles</h1>

        <p class="page-sub">
            Discover our handpicked selection of the world's finest automobiles.<br>
            Each vehicle is meticulously inspected and ready for its next owner.
        </p>

        <?php

            if(isset($_GET["success"]) && $_GET["success"]!="")
            {
                echo '<div>'.htmlspecialchars($_GET["success"]).'</div>';
            }

        ?>

        <form action="vehicles.php" method="get">

            <div class="filter-bar">

                <input type="text" class="input filter-search" name="keyword" placeholder="Search by brand or model..." value="<?php echo htmlspecialchars($keyword); ?>">


                <select class="select" name="availability">

                    <option value="">All</option>

                    <option value="available" <?php if($availability=="available"){ echo "selected"; } ?>>
                        Available
                    </option>

                    <option value="sold" <?php if($availability=="sold"){ echo "selected"; } ?>>
                        Sold
                    </option>

                </select>

                <select class="select" name="sort">

                    <option value="priceLow" <?php if($sort=="priceLow"){ echo "selected"; } ?>>
                        Price: Low to High
                    </option>

                    <option value="priceHigh" <?php if($sort=="priceHigh"){ echo "selected"; } ?>>
                        Price: High to Low
                    </option>

                    <option value="yearNew" <?php if($sort=="yearNew"){ echo "selected"; } ?>>
                        Year: Newest
                    </option>

                    <option value="brand" <?php if($sort=="brand"){ echo "selected"; } ?>>
                        Brand: A to Z
                    </option>

                </select>

                <input type="submit" class="btn btn-primary" value="Apply">

                <a href="vehicles.php" class="btn btn-ghost">Reset</a>

            </div>

        </form>

        <div class="car-grid">

            <?php

                if(count($cars)==0)
                {
                    echo '<p>No vehicles match your search.</p>';
                }

                foreach($cars as $car)
                {

            ?>

                    <div class="car-card">

                        <div class="car-photo <?php if($car["availability_status"]=="sold"){ echo "car-photo-sold"; } ?>">

                            <?php

                                if($car["image"]!="")
                                {
                                    echo '<img src="../images/'.htmlspecialchars($car["image"]).'" alt="'.htmlspecialchars($car["model"]).'">';
                                }
                                else
                                {
                                    echo '<div class="car-icon"></div>';
                                }

                                if($car["availability_status"]=="sold")
                                {
                                    echo '<div class="sold-stamp">SOLD</div>';
                                }


                            ?>

                        </div>

                        <div class="car-body">

                            <div class="car-brand">
                                <?php echo htmlspecialchars($car["brand"]); ?>
                            </div>

                            <div class="car-model">
                                <?php echo htmlspecialchars($car["model"]); ?>
                            </div>

                            <div class="car-year">
                                <?php echo htmlspecialchars($car["year"]); ?>
                            </div>

                            <div class="spec-row">

                                <div class="spec-box">

                                    <div class="spec-label">Engine</div>

                                    <div class="spec-value">
                                        <?php echo htmlspecialchars($car["engine"]); ?>
                                    </div>

                                </div>

                                <div class="spec-box">

                                    <div class="spec-label">Transmission</div>

                                    <div class="spec-value">
                                        <?php echo htmlspecialchars($car["transmission"]); ?>
                                    </div>

                                </div>

                            </div>

                            <div class="car-foot">

                                <div>

                                    <div class="price-label">
                                        Starting from
                                    </div>

                                    <div class="price-value">
                                        $<?php echo number_format($car["price"]); ?>
                                    </div>

                                </div>

                                <a
                                    href="carDetails.php?carId=<?php echo $car["car_id"]; ?>"
                                    class="btn btn-primary btn-small"
                                >
                                    View Details
                                </a>

                            </div>

                        </div>

                    </div>

            <?php
                }
            ?>

        </div>

    </div>

</body>

</html>
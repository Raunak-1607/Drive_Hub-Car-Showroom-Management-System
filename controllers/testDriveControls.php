<?php

session_start();

require_once "../models/testDrivesModel.php";
require_once "../models/carsModel.php";

if(!isset($_SESSION["userId"]))
{
    header("Location: ../views/login.php");
    exit();
}

$action="";

if(isset($_GET["action"]))
{
    $action=$_GET["action"];
}


if($_SERVER["REQUEST_METHOD"]=="POST" && $action=="request")
{
    if($_SESSION["role"]!="customer")
    {
        header("Location: ../views/login.php");
        exit();
    }

    $carId=(int)($_POST["carId"] ?? "");
    $preferredDate=$_POST["preferredDate"];
    $preferredTime=$_POST["preferredTime"];

    $dateErr="";
    $timeErr="";
    $hasErr=false;

    if($preferredDate=="")
    {
        $dateErr="Please choose a preferred date";
        $hasErr=true;
    }
    else if($preferredDate<date("Y-m-d"))
    {
        $dateErr="The date cannot be in the past";
        $hasErr=true;
    }

    if($preferredTime=="")
    {
        $timeErr="Please choose a preferred time";
        $hasErr=true;
    }

    $car=getCarById($carId);

    if(!$car)
    {
        $dateErr="This vehicle no longer exists";
        $hasErr=true;
    }
    else if($car["availability_status"]=="sold")
    {
        $dateErr="This vehicle is already sold";
        $hasErr=true;
    }

    if($hasErr)
    {
        $url="../views/customerPages/requestTestDrive.php?carId=".$carId
            ."&dateErr=".urlencode($dateErr)
            ."&timeErr=".urlencode($timeErr);
        header("Location: ".$url);
        exit();
    }
    else
    {
        $saved=addTestDrive($_SESSION["userId"], $carId, $preferredDate, $preferredTime);

        if($saved)
        {
            header("Location: ../views/customerPages/customerDashboard.php?success=".urlencode("Test drive request submitted. It is now Pending."));
            exit();
        }
        else
        {
            header("Location: ../views/customerPages/requestTestDrive.php?carId=".$carId."&dateErr=".urlencode("Could not save the request."));
            exit();
        }
    }
}


else
{
    header("Location: ../views/login.php");
    exit();
}

?>

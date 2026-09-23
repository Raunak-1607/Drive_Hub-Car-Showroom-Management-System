<?php

session_start();

require_once "../models/inquiriesModel.php";
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

if($_SERVER["REQUEST_METHOD"]=="POST" && $action=="send")
{
    if($_SESSION["role"]!="customer")
    {
        header("Location: ../views/login.php");
        exit();
    }

    $carId=$_POST["carId"];
    $message=trim($_POST["message"]);

    $messageErr="";
    $hasErr=false;

    if($message=="")
    {
        $messageErr="Your message cannot be empty";
        $hasErr=true;
    }
    else if(strlen($message)<10)
    {
        $messageErr="Please write at least 10 characters";
        $hasErr=true;
    }

    if(!getCarById($carId))
    {
        $messageErr="This vehicle no longer exists";
        $hasErr=true;
    }

    if($hasErr)
    {
        header("Location: ../views/customerPages/sendInquiry.php?carId=".$carId."&messageErr=".urlencode($messageErr));
        exit();
    }
    else
    {
        $saved=addInquiry($_SESSION["userId"], $carId, $message);

        if($saved)
        {
            header("Location: ../views/customerPages/customerDashboard.php?success=".urlencode("Inquiry submitted. It is now Pending."));
            exit();
        }
        else
        {
            header("Location: ../views/customerPages/sendInquiry.php?carId=".$carId."&messageErr=".urlencode("Could not save the inquiry."));
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

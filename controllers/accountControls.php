<?php

session_start();
require_once "../models/usersModel.php";

if(!isset($_SESSION["userId"]))
{
    header("Location: ../views/login.php");
    exit();
}

$userId=$_SESSION["userId"];

$action="";

if(isset($_GET["action"]))
{
    $action=$_GET["action"];
}

if($_SERVER["REQUEST_METHOD"]=="POST" && $action=="updateProfile")
{
    $name=trim($_POST["name"]);
    $email=trim($_POST["email"]);
    $phone=trim($_POST["phone"]);

    $nameErr="";
    $emailErr="";
    $phoneErr="";
    $hasErr=false;

    if($name=="")
    {
        $nameErr="Name cannot be empty";
        $hasErr=true;
    }

    else if(!preg_match("/^[a-zA-Z' -]+$/", $name))
    {
        $nameErr="Name cannot contain numbers or special characters";
        $hasErr=true;
    }

    if($email=="")
    {
        $emailErr="Email cannot be empty";
        $hasErr=true;
    }

    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $emailErr="Invalid email format";
        $hasErr=true;
    }

    else
    {
        $otherUser=getUserByEmail($email);

        if($otherUser && $otherUser["user_id"]!=$userId)
        {
            $emailErr="Another account already uses this email";
            $hasErr=true;
        }
    }

    if($phone=="")
    {
        $phoneErr="Phone number cannot be empty";
        $hasErr=true;
    }
    else if(!preg_match("/^[0-9+() -]+$/", $phone))
    {
        $phoneErr="Phone can only contain numbers, +, (), - and spaces";
        $hasErr=true;
    }

    if($hasErr)
    {
        $url="../views/customerPages/editProfile.php?nameErr=".urlencode($nameErr)
            ."&emailErr=".urlencode($emailErr)
            ."&phoneErr=".urlencode($phoneErr);
        header("Location: ".$url);
        exit();
    }
    else
    {
        $saved=updateUserProfile($userId, $name, $email, $phone);

        if($saved)
        {
            $_SESSION["name"]=$name;
            header("Location: ../views/customerPages/profile.php?success=".urlencode("Profile updated successfully."));
            exit();
        }
        else
        {
            header("Location: ../views/customerPages/editProfile.php?nameErr=".urlencode("Could not save your profile. Please try again."));
            exit();
        }
    }
}

else if($_SERVER["REQUEST_METHOD"]=="POST" && $action=="changePassword")
{
    $currentPassword=$_POST["currentPassword"];
    $newPassword=$_POST["newPassword"];
    $conPassword=$_POST["conPassword"];

    $currentPasswordErr="";
    $newPasswordErr="";
    $conPasswordErr="";
    $hasErr=false;

    $user=getUserById($userId);

    if($currentPassword=="")
    {
        $currentPasswordErr="Current password cannot be empty";
        $hasErr=true;
    }
    else if(!password_verify($currentPassword, $user["password"]))
    {
        $currentPasswordErr="Current password is incorrect";
        $hasErr=true;
    }

    if($newPassword=="")
    {
        $newPasswordErr="New password cannot be empty";
        $hasErr=true;
    }
    else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $newPassword))
    {
        $newPasswordErr="Password needs 8+ characters, one small letter, one capital letter, one number and one special character";
        $hasErr=true;
    }

    if($conPassword!=$newPassword)
    {
        $conPasswordErr="The two passwords do not match";
        $hasErr=true;
    }

    if($hasErr)
    {
        $url="../views/customerPages/changePassword.php?currentPasswordErr=".urlencode($currentPasswordErr)
            ."&newPasswordErr=".urlencode($newPasswordErr)
            ."&conPasswordErr=".urlencode($conPasswordErr);
        header("Location: ".$url);
        exit();
    }
    else
    {
        $hashedPassword=password_hash($newPassword, PASSWORD_DEFAULT);
        $saved=updateUserPassword($userId, $hashedPassword);

        if($saved)
        {
            header("Location: ../views/customerPages/profile.php?success=".urlencode("Password updated successfully."));
            exit();
        }
        else
        {
            header("Location: ../views/customerPages/changePassword.php?newPasswordErr=".urlencode("Could not update the password. Please try again."));
            exit();
        }
    }
}

else if($action=="deleteAccount")
{
    $deleted=deleteUser($userId);

    if($deleted)
    {
        session_unset();
        session_destroy();
        header("Location: ../views/login.php?success=".urlencode("Your account has been deleted."));
        exit();
    }
    else
    {
        header("Location: ../views/customerPages/profile.php?formErr=".urlencode("Could not delete the account. You may still have records linked to it."));
        exit();
    }
}

else
{
    header("Location: ../views/customerPages/profile.php");
    exit();
}

?>

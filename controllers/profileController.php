<?php
require_once "../models/employeeModel.php";
session_start();

if(!isset($_SESSION["userId"]))
{
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION["userId"];
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if($_POST['action'] == 'edit_profile')
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $nameErr = "";
        $emailErr = "";
        $hasErr = false;
        if(empty($name))
        {
            $hasErr = true;
            $nameErr = "Name cannot be empty";
        }
        if(empty($email))
        {
            $hasErr = true;
            $emailErr = "Email cannot be empty";
        }
        if($hasErr)
        {
            header("Location: ../views/Employee/edit_profile.php?nameErr=".$nameErr."&emailErr=".$emailErr);
            exit();
        }
        updateProfile($userId, $name, $email, $phone);
        header("Location: ../views/Employee/profile.php?msg=profile_updated");
        exit();
    }
    else if($_POST['action'] == 'change_password')
    {
        $currentPass = $_POST['current_password'];
        $newPass = $_POST['new_password'];
        $confirmPass = $_POST['confirm_password'];
        $currentPassErr = "";
        $newPassErr = "";
        $confirmPassErr = "";
        $hasErr = false;
        if(empty($currentPass))
        {
            $hasErr = true;
            $currentPassErr = "Current password cannot be empty";
        }
        else
        {
            $dbHash = getPasswordHash($userId);
            if(!password_verify($currentPass, $dbHash))
            {
                $hasErr = true;
                $currentPassErr = "Incorrect current password";
            }
        }
        if(empty($newPass))
        {
            $hasErr = true;
            $newPassErr = "New password cannot be empty";
        }
        if(empty($confirmPass))
        {
            $hasErr = true;
            $confirmPassErr = "Confirm password cannot be empty";
        }
        if(!empty($newPass) && !empty($confirmPass) && $newPass != $confirmPass)
        {
            $hasErr = true;
            $confirmPassErr = "New passwords do not match";
        }
        if($hasErr)
        {
            header("Location: ../views/Employee/change_password.php?currentPassErr=".$currentPassErr."&newPassErr=".$newPassErr."&confirmPassErr=".$confirmPassErr);
            exit();
        }
        $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
        updatePassword($userId, $hashedPass);
        header("Location: ../views/Employee/profile.php?msg=password_updated");
        exit();
    }
}
header("Location: ../views/Employee/profile.php");
exit();
?>

<?php

session_start();

require_once "../models/usersModel.php";

$action="";

if(isset($_GET["action"]))
{
    $action=$_GET["action"];
}

if($_SERVER["REQUEST_METHOD"]=="POST" && $action=="verify")
{
    $email=trim($_POST["email"]);
    $securityQuestion=$_POST["securityQuestion"];
    $securityAnswer=trim($_POST["securityAnswer"]);

    $emailErr="";
    $securityQuestionErr="";
    $securityAnswerErr="";
    $verifyErr="";
    $hasErr=false;

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

    if($securityQuestion=="")
    {
        $securityQuestionErr="Please select your security question";
        $hasErr=true;
    }

    if($securityAnswer=="")
    {
        $securityAnswerErr="Please type your answer";
        $hasErr=true;
    }

    if($hasErr)
    {
        $url="../views/forgotPassword.php?emailErr=".urlencode($emailErr)
            ."&securityQuestionErr=".urlencode($securityQuestionErr)
            ."&securityAnswerErr=".urlencode($securityAnswerErr);
        header("Location: ".$url);

        exit();
    }

    else
    {
        $user=getUserByEmail($email);

        if($user && $user["security_question"]==$securityQuestion && password_verify(strtolower($securityAnswer), $user["security_answer"]))
        {
            $_SESSION["resetUserId"]=$user["user_id"];
            header("Location: ../views/resetPassword.php");
            exit();
        }
        else
        {
            $verifyErr="The details you entered do not match any account";
            header("Location: ../views/forgotPassword.php?verifyErr=".urlencode($verifyErr));
            exit();
        }
    }
}

else if($_SERVER["REQUEST_METHOD"]=="POST" && $action=="reset")
{

    if(!isset($_SESSION["resetUserId"]))
    {
        header("Location: ../views/forgotPassword.php");
        exit();
    }

    $newPassword=$_POST["newPassword"];
    $conPassword=$_POST["conPassword"];

    $newPasswordErr="";
    $conPasswordErr="";
    $hasErr=false;

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
        $url="../views/resetPassword.php?newPasswordErr=".urlencode($newPasswordErr)
            ."&conPasswordErr=".urlencode($conPasswordErr);
        header("Location: ".$url);
        exit();
    }

    else
    {
        $hashedPassword=password_hash($newPassword, PASSWORD_DEFAULT);
        $saved=updateUserPassword($_SESSION["resetUserId"], $hashedPassword);

        if($saved)
        {
            unset($_SESSION["resetUserId"]);
            header("Location: ../views/login.php?success=".urlencode("Password updated. Please sign in."));
            exit();
        }
        else
        {
            header("Location: ../views/resetPassword.php?newPasswordErr=".urlencode("Could not update the password. Please try again."));
            exit();
        }
    }
}

else
{
    header("Location: ../views/forgotPassword.php");
    exit();
}

?>

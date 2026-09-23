<?php

require_once "../models/usersModel.php";


if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $name=trim($_POST["name"]);
    $email=trim($_POST["email"]);
    $phone=trim($_POST["phone"]);
    $password=$_POST["password"];
    $conPassword=$_POST["conPassword"];
    $securityQuestion=$_POST["securityQuestion"];
    $securityAnswer=trim($_POST["securityAnswer"]);

    $nameErr="";
    $emailErr="";
    $phoneErr="";
    $passwordErr="";
    $conPasswordErr="";
    $securityQuestionErr="";
    $securityAnswerErr="";
    $hasErr=false;

    if($name=="")
    {
        $nameErr="Name cannot be empty";
        $hasErr=true;
    }

    else if(strlen($name)<3)
    {
        $nameErr="Name must be at least 3 characters";
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

    else if(getUserByEmail($email))
    {
        $emailErr="This email is already registered";
        $hasErr=true;
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

    if($password=="")
    {
        $passwordErr="Password cannot be empty";
        $hasErr=true;
    }

    else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password))
    {
        $passwordErr="Password needs 8+ characters, one small letter, one capital letter, one number and one special character";
        $hasErr=true;
    }

    if($conPassword=="")
    {
        $conPasswordErr="Please confirm your password";
        $hasErr=true;
    }

    else if($conPassword!=$password)
    {
        $conPasswordErr="Confirm password does not match the password";
        $hasErr=true;
    }

    if($securityQuestion=="")
    {
        $securityQuestionErr="Please select a security question";
        $hasErr=true;
    }

    if($securityAnswer=="")
    {
        $securityAnswerErr="Security answer cannot be empty";
        $hasErr=true;
    }

    if($hasErr)
    {
        $url="../views/register.php?nameErr=".urlencode($nameErr)
            ."&emailErr=".urlencode($emailErr)
            ."&phoneErr=".urlencode($phoneErr)
            ."&passwordErr=".urlencode($passwordErr)
            ."&conPasswordErr=".urlencode($conPasswordErr)
            ."&securityQuestionErr=".urlencode($securityQuestionErr)
            ."&securityAnswerErr=".urlencode($securityAnswerErr);
        header("Location: ".$url);
        exit();
    }
    else
    {
        $hashedPassword=password_hash($password, PASSWORD_DEFAULT);

        $hashedAnswer=password_hash(strtolower($securityAnswer), PASSWORD_DEFAULT);

        $saved=addUser($name, $email, $phone, $hashedPassword, "customer", "active", $securityQuestion, $hashedAnswer);

        if($saved)
        {
            header("Location: ../views/login.php?success=".urlencode("Account created. You can sign in now."));
            exit();
        }
        else
        {
            header("Location: ../views/register.php?formErr=".urlencode("Could not create the account. Please try again."));
            exit();
        }
    }
}

else
{
    header("Location: ../views/register.php");
    exit();
}

?>

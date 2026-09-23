<?php

require_once "../models/usersModel.php";


if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $email=trim($_POST["email"]);
    $password=$_POST["password"];

    $emailErr="";
    $passwordErr="";
    $loginErr="";
    $hasErr=false;

    if(empty($email))
    {
        $emailErr="Email cannot be empty";
        $hasErr=true;
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $emailErr="Please enter a valid email address";
        $hasErr=true;
    }

    if(empty($password))
    {
        $passwordErr="Password cannot be empty";
        $hasErr=true;
    }

    if($hasErr)
    {
        $url="../views/login.php?emailErr=".urlencode($emailErr)."&passwordErr=".urlencode($passwordErr);
        header("Location: ".$url);
        exit();
    }
    else
    {
        $user=getUserByEmail($email);

        if($user)
        {
            if(password_verify($password, $user["password"]))
            {

                session_start();

                $_SESSION["userId"]=$user["user_id"];
                $_SESSION["role"]=$user["role"];
                $_SESSION["name"]=$user["name"];

                if($user["role"]=="customer")
                {
                    header("Location: ../views/customerPages/vehicles.php");
                    exit();
                }
                elseif($user["role"]=="admin")
                {
                    header("Location: ../views/overview_admin.php");
                    exit();
                }
                elseif($user["role"]=="employee")
                {
                    header("Location: ../views/Employee/overview.php");
                    exit();
                }
            }
            else
            {
                $loginErr="Email or password is incorrect";
                header("Location: ../views/login.php?loginErr=".urlencode($loginErr));
                exit();
            }
        }
        else
        {
            $loginErr="Email or password is incorrect";
            header("Location: ../views/login.php?loginErr=".urlencode($loginErr));
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

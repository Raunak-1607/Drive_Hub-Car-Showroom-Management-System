<?php

require_once "dbConnect.php";

// looking for user using email-------------------------------

function getUserByEmail($email)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT * FROM users WHERE email=?";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        if($result)
        {
            $row=mysqli_fetch_assoc($result);
            return $row;
        }
        else
        {
            echo "sql query execution failed. ".mysqli_error($conn);
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
    }
}


// Finding user by their id---------------------

function getUserById($userId)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT * FROM users WHERE user_id=?";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'i', $userId);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        if($result)
        {
            $row=mysqli_fetch_assoc($result);
            return $row;
        }
        else
        {
            echo "sql query execution failed. ".mysqli_error($conn);
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
    }
}


// user registration and add employye by admin ---------------

function addUser($name, $email, $phone, $password, $role, $accountStatus, $securityQuestion, $securityAnswer)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="INSERT INTO users (name, email, phone, password, role, account_status, security_question, security_answer) VALUES (?,?,?,?,?,?,?,?)";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'ssssssss', $name, $email, $phone, $password, $role, $accountStatus, $securityQuestion, $securityAnswer);

        if(mysqli_stmt_execute($stmt))
        {
            return true;
        }
        else
        {
            echo "Error inserting user: ".mysqli_error($conn);
            return false;
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
        return false;
    }
}


// User Update own info ----------------------------

function updateUserProfile($userId, $name, $email, $phone)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="UPDATE users SET name=?, email=?, phone=? WHERE user_id=?";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $phone, $userId);

        if(mysqli_stmt_execute($stmt))
        {
            return true;
        }
        else
        {
            echo "Error updating profile: ".mysqli_error($conn);
            return false;
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
        return false;
    }
}


// Change  or Forgot Password -----------------------------------

function updateUserPassword($userId, $hashedPassword)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="UPDATE users SET password=? WHERE user_id=?";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'si', $hashedPassword, $userId);

        if(mysqli_stmt_execute($stmt))
        {
            return true;
        }
        else
        {
            echo "Error updating password: ".mysqli_error($conn);
            return false;
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
        return false;
    }
}


// delete account by yser or admin----------------------------------

function deleteUser($userId)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="DELETE FROM users WHERE user_id=?";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'i', $userId);

        if(mysqli_stmt_execute($stmt))
        {
            return true;
        }
        else
        {
            echo "Error deleting user: ".mysqli_error($conn);
            return false;
        }
    }
    else
    {
        echo "connection failed. something went wrong. ";
        return false;
    }
}

?>

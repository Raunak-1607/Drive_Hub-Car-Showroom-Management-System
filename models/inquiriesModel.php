<?php

require_once __DIR__."/dbConnect.php";

function addInquiry($customerId, $carId, $message)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="INSERT INTO inquiries (customer_id, car_id, message, inquiry_status) VALUES (?,?,?,'pending')";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'iis', $customerId, $carId, $message);

        if(mysqli_stmt_execute($stmt))
        {
            return true;
        }
        else
        {
            echo "Error saving inquiry: ".mysqli_error($conn);
            return false;
        }

    }

    else
    {
        echo "connection failed. something went wrong. ";
        return false;
    }
}

function getInquiriesByCustomer($customerId)
{
    $conn=dbConnection();
    $inquiries=[];

    if($conn)
    {
        $sql="SELECT inquiries.*, cars.brand, cars.model
              FROM inquiries
              JOIN cars ON inquiries.car_id=cars.car_id
              WHERE inquiries.customer_id=?
              ORDER BY inquiries.inquiry_id DESC";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'i', $customerId);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        if($result)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $inquiries[]=$row;
            }
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

    return $inquiries;
}

function getInquiryById($inquiryId)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT inquiries.*, users.name AS customer_name, users.email AS customer_email, cars.brand, cars.model
              FROM inquiries
              JOIN users ON inquiries.customer_id=users.user_id
              JOIN cars ON inquiries.car_id=cars.car_id
              WHERE inquiries.inquiry_id=?";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'i', $inquiryId);
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

?>

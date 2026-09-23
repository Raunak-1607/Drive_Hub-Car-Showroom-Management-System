<?php

require_once __DIR__."/dbConnect.php";

function addTestDrive($customerId, $carId, $preferredDate, $preferredTime)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="INSERT INTO test_drives (customer_id, car_id, preferred_date, preferred_time, status) VALUES (?,?,?,?,'pending')";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'iiss', $customerId, $carId, $preferredDate, $preferredTime);

        if(mysqli_stmt_execute($stmt))
        {
            return true;
        }
        else
        {
            echo "Error saving test drive request: ".mysqli_error($conn);
            return false;
        }

    }

    else
    {
        echo "connection failed. something went wrong. ";
        return false;
    }
}

function getTestDrivesByCustomer($customerId)
{
    $conn=dbConnection();
    $testDrives=[];

    if($conn)
    {
        $sql="SELECT test_drives.*, cars.brand, cars.model
              FROM test_drives
              JOIN cars ON test_drives.car_id=cars.car_id
              WHERE test_drives.customer_id=?
              ORDER BY test_drives.testdrive_id DESC";
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
                $testDrives[]=$row;
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

    return $testDrives;
}

?>

<?php

require_once "dbConnect.php";

function getCars($keyword, $availability, $sort)
{
    $conn=dbConnection();
    $cars=[];

    if($conn)
    {
        $like="%".$keyword."%";

        if($availability=="")
        {
            $availabilityFilter="%";
        }
        else
        {
            $availabilityFilter=$availability;
        }

        $sql="SELECT * FROM cars WHERE (brand LIKE ? OR model LIKE ?) AND availability_status LIKE ?";

        if($sort=="priceHigh")
        {
            $sql=$sql." ORDER BY price DESC";
        }
        else if($sort=="yearNew")
        {
            $sql=$sql." ORDER BY year DESC";
        }
        else if($sort=="brand")
        {
            $sql=$sql." ORDER BY brand ASC";
        }
        else
        {
            $sql=$sql." ORDER BY price ASC";
        }

        $stmt=mysqli_prepare($conn, $sql);


        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $availabilityFilter);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        if($result)
        {
            while($row=mysqli_fetch_assoc($result))
            {
                $cars[]=$row;
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

    return $cars;
}


function getAllCars()
{
    return getCars("", "", "priceLow");
}


function getCarById($carId)
{
    $conn=dbConnection();

    if($conn)
    {
        $sql="SELECT * FROM cars WHERE car_id=?";
        $stmt=mysqli_prepare($conn, $sql);

        if(!$stmt)
        {
            echo "SQL error: ".mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'i', $carId);
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

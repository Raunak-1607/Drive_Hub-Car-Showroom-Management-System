<?php

$dbServerName="localhost";
$dbUserName="root";
$dbPassword="";
$dbName="dh";

function dbConnection()
{
    global $dbServerName;
    global $dbUserName;
    global $dbPassword;
    global $dbName;

    $conn=mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);

    if($conn)
    {
        return $conn;
    }
    else
    {
        echo "Database connection failed. ".mysqli_connect_error();
    }
}

?>

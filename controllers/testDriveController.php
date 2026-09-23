<?php
require_once "../models/employeeModel.php";

if(isset($_GET['action']) && isset($_GET['id']))
{
    if($_GET['action'] == 'approve')
    {
        updateTestDriveStatus($_GET['id'], 'Approved');
    }
    else if($_GET['action'] == 'reject')
    {
        updateTestDriveStatus($_GET['id'], 'Rejected');
    }
    else if($_GET['action'] == 'delete')
    {
        deleteTestDrive($_GET['id']);
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update')
{
    $id = $_POST['id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];
    $dateErr = "";
    $timeErr = "";
    $hasErr = false;
    if(empty($date))
    {
        $hasErr = true;
        $dateErr = "Date cannot be empty";
    }
    if(empty($time))
    {
        $hasErr = true;
        $timeErr = "Time cannot be empty";
    }
    if($hasErr)
    {
        header("Location: ../views/Employee/edit_test_drive.php?id=".$id."&dateErr=".$dateErr."&timeErr=".$timeErr);
        exit();
    }
    updateTestDrive($id, $date, $time, $status);
}
header("Location: ../views/Employee/test_drive_schedule.php");
exit();
?>

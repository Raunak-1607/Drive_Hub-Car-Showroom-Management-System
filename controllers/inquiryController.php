<?php
require_once "../models/employeeModel.php";

if(isset($_GET['action']) && isset($_GET['id']))
{
    $action = $_GET['action'];
    $id = $_GET['id'];
    if($action == 'resolve')
    {
        markInquiryResolved($id);
    }
    else if($action == 'delete')
    {
        deleteInquiry($id);
    }
    else if($action == 'update' && $_SERVER["REQUEST_METHOD"] == "POST")
    {
        $message = $_POST['message'];
        $status = $_POST['status'];
        if(empty($message))
        {
            header("Location: ../views/Employee/edit_inquiry.php?id=".$id."&messageErr=Message cannot be empty");
            exit();
        }
        updateInquiry($id, $message, $status);
    }
}
header("Location: ../views/Employee/inquiries.php");
exit();
?>

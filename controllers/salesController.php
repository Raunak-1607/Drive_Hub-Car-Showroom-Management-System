<?php
require_once "../models/employeeModel.php";
session_start();

if(isset($_GET['action']) && isset($_GET['id']))
{
    if($_GET['action'] == 'sold')
    {
        markVehicleSold($_GET['id']);
    }
    else if($_GET['action'] == 'delete')
    {
        deleteSale($_GET['id']);
    }
    header("Location: ../views/Employee/sales_transactions.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $action = $_POST['action'];
    if($action == 'new_sale')
    {
        $customer = $_POST['customer'];
        $vehicle = $_POST['vehicle'];
        $salePrice = $_POST['salePrice'];
        $saleDate = $_POST['saleDate'];
        $status = $_POST['saleStatus'];
        $customerErr = "";
        $vehicleErr = "";
        $salePriceErr = "";
        $saleDateErr = "";
        $hasErr = false;

        if(empty($customer))
        {
            $hasErr = true;
            $customerErr = "Customer name cannot be empty";
        }
        if(empty($vehicle))
        {
            $hasErr = true;
            $vehicleErr = "Please select a vehicle";
        }
        if(empty($salePrice))
        {
            $hasErr = true;
            $salePriceErr = "Sale price cannot be empty";
        }
        if(empty($saleDate))
        {
            $hasErr = true;
            $saleDateErr = "Please select a sale date";
        }

        if($hasErr)
        {
            header("Location: ../views/Employee/new_sale.php?customerErr=".$customerErr."&vehicleErr=".$vehicleErr."&salePriceErr=".$salePriceErr."&saleDateErr=".$saleDateErr);
            exit();
        }
        $employeeId = $_SESSION["userId"];
        $result = insertSale($customer, $vehicle, $saleDate, $salePrice, $status, $employeeId);
        if(!$result)
        {
            header("Location: ../views/Employee/new_sale.php?insertErr=Sale cannot be inserted");
            exit();
        }
    }
    else if($action == 'update')
    {
        $id = $_POST['id'];
        $customer = $_POST['customer'];
        $vehicle = $_POST['vehicle'];
        $saleDate = $_POST['saleDate'];
        $amount = $_POST['amount'];
        $status = $_POST['status'];
        $dateErr = "";
        $amountErr = "";
        $customerErr = "";
        $vehicleErr = "";
        $hasErr = false;
        if(empty($customer))
        {
            $hasErr = true;
            $customerErr = "Customer name cannot be empty";
        }
        if(empty($vehicle))
        {
            $hasErr = true;
            $vehicleErr = "Vehicle cannot be empty";
        }
        if(empty($saleDate))
        {
            $hasErr = true;
            $dateErr = "Sale date cannot be empty";
        }
        if(empty($amount))
        {
            $hasErr = true;
            $amountErr = "Amount cannot be empty";
        }
        if($hasErr)
        {
            header("Location: ../views/Employee/edit_sale.php?id=".$id."&customerErr=".$customerErr."&vehicleErr=".$vehicleErr."&dateErr=".$dateErr."&amountErr=".$amountErr);
            exit();
        }
        updateSale($id, $customer, $vehicle, $saleDate, $amount, $status);
    }
}
header("Location: ../views/Employee/sales_transactions.php");
exit();
?>

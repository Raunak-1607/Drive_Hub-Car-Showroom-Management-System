<?php

session_start();

if(!isset($_SESSION["userId"]) || $_SESSION["role"]!="admin")
{
    header("Location: login.php");
    exit();
}

require_once "../models/adminModel.php";

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action == 'delete_vehicle') {
        deleteVehicle($id);
        header("Location: ../views/vehicle_inventory.php");
        exit();
    }

    if ($action == 'delete_employee') {
        deleteEmployee($id);
        header("Location: ../views/employee_accounts.php");
        exit();
    }

    if ($action == 'activate_employee') {
        updateEmployeeStatus($id, 'active');
        header("Location: ../views/employee_accounts.php");
        exit();
    }

    if ($action == 'deactivate_employee') {
        updateEmployeeStatus($id, 'inactive');
        header("Location: ../views/employee_accounts.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'add_vehicle') {
        $brand = $_POST['brand'] ?? '';
        $model = $_POST['model'] ?? '';
        $year = $_POST['year'] ?? '';
        $price = $_POST['price'] ?? '';
        $fuelType = $_POST['fuel_type'] ?? '';
        $transmission = $_POST['transmission'] ?? '';
        $engine = $_POST['engine'] ?? '';

        if (!empty($brand) && !empty($model)) {
            addVehicle($brand, $model, $year, $price, $fuelType, $transmission, $engine);
            header("Location: ../views/vehicle_inventory.php?msg=vehicle_added");
        } else {
            header("Location: ../views/add_vehicle.php?err=empty_fields");
        }
        exit();
    }

    if ($action == 'update_vehicle') {
        $id = $_POST['car_id'] ?? '';
        $brand = $_POST['brand'] ?? '';
        $model = $_POST['model'] ?? '';
        $year = $_POST['year'] ?? '';
        $price = $_POST['price'] ?? '';
        $fuelType = $_POST['fuel_type'] ?? '';
        $transmission = $_POST['transmission'] ?? '';
        $engine = $_POST['engine'] ?? '';

        if (!empty($brand) && !empty($model)) {
            updateVehicle($id, $brand, $model, $year, $price, $fuelType, $transmission, $engine);
            header("Location: ../views/vehicle_inventory.php?msg=vehicle_updated");
        } else {
            header("Location: ../views/edit_vehicle.php?id=" . urlencode($id) . "&err=empty_fields");
        }
        exit();
    }

    if ($action == 'add_employee') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!empty($name) && !empty($email) && !empty($password)) {
            addEmployee($name, $email, $phone, $password);
            header("Location: ../views/employee_accounts.php?msg=employee_added");
        } else {
            header("Location: ../views/add_employee.php?err=empty_fields");
        }
        exit();
    }

    if ($action == 'update_employee') {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';

        if (!empty($name) && !empty($email)) {
            updateEmployee($id, $name, $email, $phone);
            header("Location: ../views/employee_accounts.php?msg=employee_updated");
        } else {
            header("Location: ../views/edit_employee.php?id=" . urlencode($id) . "&err=empty_fields");
        }
        exit();
    }

    if ($action == 'update_profile') {
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        adminUpdateUserProfile($id, $name, $email, $phone);
        header("Location: ../views/admin_profile.php?msg=profile_updated");
        exit();
    }

    if ($action == 'update_password') {
        $id = $_POST['id'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        if (!empty($newPassword)) {
            adminUpdateUserPassword($id, $newPassword);
            header("Location: ../views/admin_profile.php?msg=password_updated");
        } else {
            header("Location: ../views/admin_profile.php");
        }
        exit();
    }
}

header("Location: ../views/overview_admin.php");
exit();
?>

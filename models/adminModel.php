<?php
require_once "dbConnect.php";

function getAllVehicles() {
    $conn = dbConnection();
    if($conn) {
        $sql = "SELECT * FROM cars";
        $result = mysqli_query($conn, $sql);
        $data = [];
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    return [];
}

function getVehicleById($id) {
    $conn = dbConnection();
    if($conn) {
        $sql = "SELECT * FROM cars WHERE car_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($result && mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        }
    }
    return null;
}

function addVehicle($brand, $model, $year, $price, $fuelType, $transmission, $engine) {
    $conn = dbConnection();
    if($conn) {
        $sql = "INSERT INTO cars (brand, model, year, price, fuel_type, transmission, engine, availability_status) VALUES (?, ?, ?, ?, ?, ?, ?, 'available')";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssidsss', $brand, $model, $year, $price, $fuelType, $transmission, $engine);
            return mysqli_stmt_execute($stmt);
        }
    }
    return false;
}

function updateVehicle($id, $brand, $model, $year, $price, $fuelType, $transmission, $engine) {
    $conn = dbConnection();
    if($conn) {
        $sql = "UPDATE cars SET brand=?, model=?, year=?, price=?, fuel_type=?, transmission=?, engine=? WHERE car_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssidsssi', $brand, $model, $year, $price, $fuelType, $transmission, $engine, $id);
            return mysqli_stmt_execute($stmt);
        }
    }
    return false;
}

function deleteVehicle($id) {
    $conn = dbConnection();
    if($conn) {
        $sql = "DELETE FROM cars WHERE car_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            return mysqli_stmt_execute($stmt);
        }
    }
    return false;
}

function getAllEmployees() {
    $conn = dbConnection();
    if($conn) {
        $sql = "SELECT * FROM users WHERE role='employee'";
        $result = mysqli_query($conn, $sql);
        $data = [];
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    return [];
}

function addEmployee($name, $email, $phone, $plainPassword) {
    $conn = dbConnection();
    if($conn) {
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, phone, password, role, account_status) VALUES (?, ?, ?, ?, 'employee', 'active')";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $phone, $hashedPassword);
            return mysqli_stmt_execute($stmt);
        }
    }
    return false;
}

function updateEmployee($id, $name, $email, $phone) {
    $conn = dbConnection();
    if($conn) {
        $sql = "UPDATE users SET name=?, email=?, phone=? WHERE user_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $phone, $id);
            return mysqli_stmt_execute($stmt);
        }
    }
    return false;
}

function updateEmployeeStatus($id, $status) {
    $conn = dbConnection();
    if($conn) {
        $sql = "UPDATE users SET account_status=? WHERE user_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'si', $status, $id);
            return mysqli_stmt_execute($stmt);
        }
    }
    return false;
}

function deleteEmployee($id) {
    $conn = dbConnection();
    if($conn) {
        $sql = "DELETE FROM users WHERE user_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            return mysqli_stmt_execute($stmt);
        }
    }
    return false;
}

function getUserProfile($id) {
    $conn = dbConnection();
    if($conn) {
        $sql = "SELECT * FROM users WHERE user_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($result && mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        }
    }
    return null;
}

function adminUpdateUserProfile($id, $name, $email, $phone) {
    $conn = dbConnection();
    if($conn) {
        $sql = "UPDATE users SET name=?, email=?, phone=? WHERE user_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $phone, $id);
            return mysqli_stmt_execute($stmt);
        }
    }
    return false;
}

function adminUpdateUserPassword($id, $newPlainPassword) {
    $conn = dbConnection();
    if($conn) {
        $hashedPassword = password_hash($newPlainPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password=? WHERE user_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt) {
            mysqli_stmt_bind_param($stmt, 'si', $hashedPassword, $id);
            return mysqli_stmt_execute($stmt);
        }
    }
    return false;
}

function getShowroomReportStats() {
    $conn = dbConnection();
    if($conn) {
        $stats = [];

        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM cars");
        $stats['total_vehicles'] = $result ? mysqli_fetch_assoc($result)['total'] : 0;

        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM cars WHERE availability_status='available'");
        $stats['available_vehicles'] = $result ? mysqli_fetch_assoc($result)['total'] : 0;

        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM sales WHERE sale_status='sold'");
        $stats['total_sales'] = $result ? mysqli_fetch_assoc($result)['total'] : 0;

        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='employee'");
        $stats['total_employees'] = $result ? mysqli_fetch_assoc($result)['total'] : 0;

        return $stats;
    }
    return [];
}
?>

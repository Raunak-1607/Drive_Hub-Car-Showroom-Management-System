<?php
require_once "dbConnect.php";

function getOverviewStats()
{
    $conn = dbConnection();
    $stats = [];
    if($conn)
    {
        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM cars WHERE availability_status='available'");
        $row = mysqli_fetch_assoc($result);
        $stats[] = ['label' => 'Available Cars', 'number' => $row['total'], 'color' => '#10b981'];
        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM inquiries WHERE inquiry_status='pending'");
        $row = mysqli_fetch_assoc($result);
        $stats[] = ['label' => 'Pending Inquiries', 'number' => $row['total'], 'color' => '#f59e0b'];
        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM test_drives WHERE status='pending'");
        $row = mysqli_fetch_assoc($result);
        $stats[] = ['label' => 'Pending Test Drives', 'number' => $row['total'], 'color' => '#3b82f6'];
        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM sales WHERE sale_status='sold'");
        $row = mysqli_fetch_assoc($result);
        $stats[] = ['label' => 'Vehicles Sold', 'number' => $row['total'], 'color' => '#8b5cf6'];
    }
    return $stats;
}

function getAvailableCars()
{
    $conn = dbConnection();
    $cars = [];

    if($conn)
    {
        $sql = "SELECT car_id, brand, model FROM cars WHERE availability_status='available'";
        $result = mysqli_query($conn, $sql);

        if($result)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $cars[] = $row;
            }
        }
    }

    return $cars;
}

function getInquiries()
{
    $conn = dbConnection();
    $inquiries = [];
    if($conn)
    {
        $sql = "SELECT i.inquiry_id AS id, u.name AS customer, CONCAT(c.brand, ' ', c.model) AS vehicle, i.message, i.inquiry_date AS date, i.inquiry_status AS status FROM inquiries i JOIN users u ON i.customer_id=u.user_id JOIN cars c ON i.car_id=c.car_id";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $row['initials'] = substr($row['customer'], 0, 1);
                $row['avatarColor'] = '#3b82f6';
                if($row['status'] == 'pending')
                {
                    $row['status'] = 'Pending';
                }
                else
                {
                    $row['status'] = 'Resolved';
                }
                $inquiries[] = $row;
            }
        }
    }
    return $inquiries;
}

function getTestDrives()
{
    $conn = dbConnection();
    $drives = [];
    if($conn)
    {
        $sql = "SELECT td.testdrive_id AS id, u.name AS customer, CONCAT(c.brand, ' ', c.model) AS vehicle, td.preferred_date AS date, td.preferred_time AS time, td.status FROM test_drives td JOIN users u ON td.customer_id=u.user_id JOIN cars c ON td.car_id=c.car_id";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                if($row['status'] == 'pending')
                {
                    $row['status'] = 'Pending';
                }
                else if($row['status'] == 'approved')
                {
                    $row['status'] = 'Approved';
                }
                else if($row['status'] == 'rejected')
                {
                    $row['status'] = 'Rejected';
                }
                else
                {
                    $row['status'] = 'Completed';
                }
                $drives[] = $row;
            }
        }
    }
    return $drives;
}

function getSales()
{
    $conn = dbConnection();
    $sales = [];
    if($conn)
    {
        $sql = "SELECT s.sale_id AS id, u.name AS customer, CONCAT(c.brand, ' ', c.model) AS vehicle, s.sale_date AS saleDate, s.sale_price AS amount, s.sale_status AS status FROM sales s JOIN users u ON s.customer_id=u.user_id JOIN cars c ON s.car_id=c.car_id";
        $result = mysqli_query($conn, $sql);
        if($result)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $row['amount'] = '$' . $row['amount'];
                if($row['status'] == 'sold')
                {
                    $row['status'] = 'Sold';
                    $row['vehicleSold'] = 1;
                }
                else
                {
                    $row['status'] = 'Pending';
                    $row['vehicleSold'] = 0;
                }
                $sales[] = $row;
            }
        }
    }
    return $sales;
}

function getInquiry($id)
{
    $conn = dbConnection();
    $sql = "SELECT * FROM inquiries WHERE inquiry_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function markInquiryResolved($id)
{
    $conn = dbConnection();
    $sql = "UPDATE inquiries SET inquiry_status='resolved' WHERE inquiry_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

function deleteInquiry($id)
{
    $conn = dbConnection();
    $sql = "DELETE FROM inquiries WHERE inquiry_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

function updateInquiry($id, $message, $status)
{
    $conn = dbConnection();
    $sql = "UPDATE inquiries SET message=?, inquiry_status=? WHERE inquiry_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssi', $message, $status, $id);
    return mysqli_stmt_execute($stmt);
}

function getTestDrive($id)
{
    $conn = dbConnection();
    $sql = "SELECT td.testdrive_id AS id, u.name AS customer, CONCAT(c.brand, ' ', c.model) AS vehicle, td.preferred_date AS date, td.preferred_time AS time, td.status FROM test_drives td JOIN users u ON td.customer_id=u.user_id JOIN cars c ON td.car_id=c.car_id WHERE td.testdrive_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateTestDriveStatus($id, $status)
{
    $conn = dbConnection();
    $status = strtolower($status);
    $sql = "UPDATE test_drives SET status=? WHERE testdrive_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $status, $id);
    return mysqli_stmt_execute($stmt);
}

function deleteTestDrive($id)
{
    $conn = dbConnection();
    $sql = "DELETE FROM test_drives WHERE testdrive_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

function updateTestDrive($id, $date, $time, $status)
{
    $conn = dbConnection();
    $status = strtolower($status);
    $sql = "UPDATE test_drives SET preferred_date=?, preferred_time=?, status=? WHERE testdrive_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssi', $date, $time, $status, $id);
    return mysqli_stmt_execute($stmt);
}

function getSale($id)
{
    $conn = dbConnection();
    $sql = "SELECT s.sale_id AS id, u.name AS customer, CONCAT(c.brand, ' ', c.model) AS vehicle, s.sale_date AS saleDate, s.sale_price AS amount, s.sale_status AS status FROM sales s JOIN users u ON s.customer_id=u.user_id JOIN cars c ON s.car_id=c.car_id WHERE s.sale_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function markVehicleSold($id)
{
    $conn = dbConnection();
    $sql = "UPDATE sales SET sale_status='sold' WHERE sale_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

function deleteSale($id)
{
    $conn = dbConnection();
    $sql = "DELETE FROM sales WHERE sale_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

function updateSale($id, $customer, $vehicle, $saleDate, $amount, $status)
{
    $conn = dbConnection();
    $customerId = 0;
    $carId = 0;
    $stmt1 = mysqli_prepare($conn, "SELECT user_id FROM users WHERE name=?");
    mysqli_stmt_bind_param($stmt1, 's', $customer);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    if(mysqli_num_rows($result1) > 0)
    {
        $row = mysqli_fetch_assoc($result1);
        $customerId = $row['user_id'];
    }
    else
    {
        $email = $customer . "@gmail.com";
        $password = "123456";
        $sql = "INSERT INTO users (name, email, password, role, account_status) VALUES (?, ?, ?, 'customer', 'active')";
        $stmt_insert = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt_insert, 'sss', $customer, $email, $password);
        mysqli_stmt_execute($stmt_insert);
        $customerId = mysqli_insert_id($conn);
    }
    $stmt2 = mysqli_prepare($conn, "SELECT car_id FROM cars WHERE CONCAT(brand, ' ', model)=?");
    mysqli_stmt_bind_param($stmt2, 's', $vehicle);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    if(mysqli_num_rows($result2) > 0)
    {
        $row = mysqli_fetch_assoc($result2);
        $carId = $row['car_id'];
    }
    $status = strtolower($status);
    $sql = "UPDATE sales SET customer_id=?, car_id=?, sale_date=?, sale_price=?, sale_status=? WHERE sale_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iisisi', $customerId, $carId, $saleDate, $amount, $status, $id);
    return mysqli_stmt_execute($stmt);
}

function getProfile($userId)
{
    $conn = dbConnection();
    $sql = "SELECT user_id AS id, name, email, phone, role, account_status AS status FROM users WHERE user_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateProfile($userId, $name, $email, $phone)
{
    $conn = dbConnection();
    $sql = "UPDATE users SET name=?, email=?, phone=? WHERE user_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $phone, $userId);
    return mysqli_stmt_execute($stmt);
}

function updatePassword($userId, $newPassword)
{
    $conn = dbConnection();
    $sql = "UPDATE users SET password=? WHERE user_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $newPassword, $userId);
    return mysqli_stmt_execute($stmt);
}

function getPasswordHash($userId)
{
    $conn = dbConnection();
    $sql = "SELECT password FROM users WHERE user_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['password'];
    }
    return null;
}

function insertSale($customer, $vehicle, $saleDate, $amount, $status, $employeeId)
{
    $conn = dbConnection();
    $customerId = 0;
    $carId = 0;
    $stmt1 = mysqli_prepare($conn, "SELECT user_id FROM users WHERE name=?");
    mysqli_stmt_bind_param($stmt1, 's', $customer);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    if(mysqli_num_rows($result1) > 0)
    {
        $row = mysqli_fetch_assoc($result1);
        $customerId = $row['user_id'];
    }
    else
    {
        $email = $customer . "@gmail.com";
        $password = "123456";
        $sql = "INSERT INTO users (name, email, password, role, account_status) VALUES (?, ?, ?, 'customer', 'active')";
        $stmt_insert = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt_insert, 'sss', $customer, $email, $password);
        mysqli_stmt_execute($stmt_insert);
        $customerId = mysqli_insert_id($conn);
    }
    $stmt2 = mysqli_prepare($conn, "SELECT car_id FROM cars WHERE CONCAT(brand, ' ', model)=?");
    mysqli_stmt_bind_param($stmt2, 's', $vehicle);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    if(mysqli_num_rows($result2) > 0)
    {
        $row = mysqli_fetch_assoc($result2);
        $carId = $row['car_id'];
    }
    $status = strtolower($status);
    $sql = "INSERT INTO sales (customer_id, employee_id, car_id, sale_price, sale_date, sale_status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iiiiss', $customerId, $employeeId, $carId, $amount, $saleDate, $status);
    return mysqli_stmt_execute($stmt);
}
?>

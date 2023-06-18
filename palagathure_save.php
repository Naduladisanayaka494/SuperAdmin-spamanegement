<?php
// Assuming you have a MySQL database set up with the following credentials
$host = 'localhost';
$db = 'expense_budget_db';
$user = 'root';
$password = '';

// Connect to the database
$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create the table if it doesn't exist
$tableName = 'spa_data'; // Change this to your desired table name
$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS $tableName (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(100) NOT NULL,
                        date DATE NOT NULL,
                        in_time TIME NOT NULL,
                        out_time TIME NOT NULL,
                        service_type VARCHAR(50) NOT NULL,
                        branch VARCHAR(100) NOT NULL,
                        amount DECIMAL(10, 2) NOT NULL
                    )");
$stmt->execute();

// Get the form data
$name = $_POST['name'];
$date = $_POST['in-date'];
$inTime = $_POST['in-time'];
$outTime = $_POST['out-time'];
$serviceType = $_POST['service-type'];
$branch = "Palagathure";
$amount01 = "";
$amount02 = "";
if ($serviceType === "Full") {
    $amount01 = $_POST['dropdown-value'];
    $amount02 = $amount01 / 2;
} else if ($serviceType === "Normal") {
    $amount02 = "1500";
} else if ($serviceType === "Oil") {
    $amount02 = "2000";
}

// Insert the data into the table
$stmt = $conn->prepare("INSERT INTO $tableName (name, date, in_time, out_time, service_type, branch, amount) 
                        VALUES (:name, :date, :inTime, :outTime, :serviceType, :branch, :amount)");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':inTime', $inTime);
$stmt->bindParam(':outTime', $outTime);
$stmt->bindParam(':serviceType', $serviceType);
$stmt->bindParam(':branch', $branch);
$stmt->bindParam(':amount', $amount02);
$stmt->execute();

// Redirect back to the form or any other page
header("Location: palagathure.php");
exit();

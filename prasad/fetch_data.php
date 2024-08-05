<?php
// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "13.202.161.38";
$username = "root";
$password = "ssauto"; // Correct password as per your setup
$dbname = "test"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dynamic table name based on the current date
$table_name = "cage_data_" . date('Y_m_d');

// Fetch OK Production Count
$okProductionQuery = "SELECT COUNT(*) AS ok_count FROM `$table_name` WHERE LENGTH(Reason) = 2";
$okProductionResult = $conn->query($okProductionQuery);
if (!$okProductionResult) {
    die("Query failed: " . $conn->error);
}
$okProductionCount = $okProductionResult->fetch_assoc()['ok_count'];

// Fetch Not OK Production Count
$notOkProductionQuery = "SELECT COUNT(*) AS not_ok_count FROM `$table_name` WHERE LENGTH(Reason) != 2";
$notOkProductionResult = $conn->query($notOkProductionQuery);
if (!$notOkProductionResult) {
    die("Query failed: " . $conn->error);
}
$notOkProductionCount = $notOkProductionResult->fetch_assoc()['not_ok_count'];

// Fetch Total Production Count
$totalProductionQuery = "SELECT COUNT(*) AS total_count FROM `$table_name`";
$totalProductionResult = $conn->query($totalProductionQuery);
if (!$totalProductionResult) {
    die("Query failed: " . $conn->error);
}
$totalProductionCount = $totalProductionResult->fetch_assoc()['total_count'];

// Create response array
$response = [
    'ok_production_count' => $okProductionCount,
    'not_ok_production_count' => $notOkProductionCount,
    'total_production_count' => $totalProductionCount,
    'data' => [] // This will hold the detailed data if needed
];

// Fetch detailed data (if needed)
$detailedDataQuery = "SELECT * FROM `$table_name`";
$detailedDataResult = $conn->query($detailedDataQuery);
if (!$detailedDataResult) {
    die("Query failed: " . $conn->error);
}
while($row = $detailedDataResult->fetch_assoc()) {
    $response['data'][] = $row;
}

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close connection
$conn->close();
?>

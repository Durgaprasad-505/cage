<?php

// Database connection parameters
$servername = "13.202.161.38";  // Replace with your server name
$username = "root";     // Replace with your database username
$password = "ssauto";     // Replace with your database password
$dbname = "test";       // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch last status from the database
$sql = "SELECT status FROM check_status WHERE id = 1"; // Assuming 'id' is your primary key

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'];
    
    // Check machine status based on the fetched status
    $machine_status = ($status == 'True'); // Adjust based on your actual data format
    
    // Return machine status as JSON
    echo json_encode(array('machine_status' => $machine_status));
} else {
    echo json_encode(array('error' => 'No status data found'));
}

$conn->close();

?>

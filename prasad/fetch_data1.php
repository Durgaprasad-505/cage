<?php
header('Content-Type: application/json');

$servername = "13.202.161.38"; // MySQL server address
$username = "root"; // MySQL username
$password = "ssauto"; // MySQL password
$dbname = "test"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// SQL statement for selecting all data from the table
$sql = "SELECT id, Date, Time, camA_OD, camB_OD, camC_OD, camD_OD, camA_SH, camB_SH_left, camB_SH_right, camC_SH, camD_SH_left, camD_SH_right, camA_WW, camB_WW_right, camB_WW_left, camC_WW, camD_WW_left, camD_WW_right, Reason FROM cage_data_" . date('Y_m_d');
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo json_encode(['error' => 'No data found']);
    $conn->close();
    exit;
}

$conn->close();
echo json_encode(['records' => $data]);
?>

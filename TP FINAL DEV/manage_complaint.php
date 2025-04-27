<?php

$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'complaints_db';


$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];
    $reply = $_POST['reply'];

  
    $query = "UPDATE complaints SET status='$status', reply='$reply' WHERE id=$complaint_id";
    if ($conn->query($query) === TRUE) {
        echo "Complaint updated successfully!";
    } else {
        echo "Error updating complaint: " . $conn->error;
    }
}

$conn->close();
?>

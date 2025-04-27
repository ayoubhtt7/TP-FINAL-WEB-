<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaints_db";


// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_name = isset($_POST['client_name']) ? $conn->real_escape_string($_POST['client_name']) : null;
    $issue_type = isset($_POST['issue_type']) ? $conn->real_escape_string($_POST['issue_type']) : null;
    $severity = isset($_POST['severity']) ? $conn->real_escape_string($_POST['severity']) : null;
    $description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : null;

    if ($client_name && $issue_type && $severity && $description) {
        $sql = "INSERT INTO complaints (client_name, issue_type, severity, description) 
                VALUES ('$client_name', '$issue_type', '$severity', '$description')";

        if ($conn->query($sql) === TRUE) {
            echo "Complaint submitted successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please fill out all fields.";
    }
}

$conn->close();
?>

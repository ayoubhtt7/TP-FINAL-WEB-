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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  
    $query = "INSERT INTO add_users (username, password, role) VALUES ('$username', '$hashedPassword', '$role')";
    if ($conn->query($query) === TRUE) {
        echo "User added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<?php
session_start();


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

  
    $query = "SELECT * FROM add_users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header('Location: index.html');
exit();

    } else {
        echo "Invalid credentials!";
    }
}

$conn->close();
?>

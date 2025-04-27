<?php
// Database connection
$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'complaints_db';

$conn = new mysqli($host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle actions for managing users
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $user_id = $_POST['user_id'];

    if ($action === 'block') {
        $query = "UPDATE add_users SET status = 'blocked' WHERE id = $user_id";
        $conn->query($query);
        echo "User blocked successfully!";
    } elseif ($action === 'edit') {
        $username = $_POST['username'];
        $role = $_POST['role'];
        $query = "UPDATE add_users SET username = '$username', role = '$role' WHERE id = $user_id";
        $conn->query($query);
        echo "User updated successfully!";
    }
}

// Fetch users to display in the table
$query = "SELECT id, username, role, status FROM add_users";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4fb4f8, #6d83f2);
            height: 100vh;
            display: flex;
            flex-direction: column; /* Adjusted for the return button */
            align-items: center;
            animation: backgroundAnimation 8s infinite alternate;
        }

        @keyframes backgroundAnimation {
            0% { background: linear-gradient(135deg, #4fb4f8, #6d83f2); }
            100% { background: linear-gradient(135deg, #6d83f2, #4fb4f8); }
        }

        /* Return Button Styling */
        .return-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 15px;
            background-color: white;
            color: #4fb4f8;
            border: 2px solid #4fb4f8;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s, transform 0.2s;
            text-decoration: none; /* Ensure it looks like a button */
        }

        .return-btn:hover {
            background-color: #4fb4f8;
            color: white;
            transform: scale(1.05);
        }

        .return-btn:active {
            transform: scale(1);
        }

        /* Container Styling */
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 700px;
            margin-top: 60px; /* Prevent overlap with the button */
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .container h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        table th {
            background-color: #4fb4f8;
            color: white;
        }

        table td {
            background-color: #f9f9f9;
        }

        table tr:hover td {
            background-color: #e3effe;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        form input[type="text"], form select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9rem;
            width: 120px;
            transition: box-shadow 0.3s, border-color 0.3s;
        }

        form input:focus, form select:focus {
            border-color: #4fb4f8;
            box-shadow: 0 0 8px rgba(76, 132, 255, 0.5);
            outline: none;
        }

        form button {
            padding: 10px 15px;
            background-color: #4fb4f8;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        form button:hover {
            background-color: #6d83f2;
            transform: scale(1.05);
        }

        form button:active {
            transform: scale(1);
        }
    </style>
</head>
<body>
    <a href="index.html" class="return-btn">← Back to Homepage</a> <!-- Return Button -->

    <div class="container">
        <h2>Manage Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['role']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <form method='post'>
                                    <input type='hidden' name='user_id' value='{$row['id']}'>
                                    <button name='action' value='block'>Block</button>
                                    <button name='action' value='edit'>Edit</button>
                                    <input type='text' name='username' placeholder='New Username'>
                                    <select name='role'>
                                        <option value='admin'>Admin</option>
                                        <option value='client'>Client</option>
                                    </select>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>

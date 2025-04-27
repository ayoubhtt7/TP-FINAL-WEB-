<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaints_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $conn->real_escape_string($_POST['service_name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);

    $sql = "INSERT INTO services (service_name, description, price) VALUES ('$service_name', '$description', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Service added successfully!</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $conn->real_escape_string($_GET['delete_id']);
    $sql = "DELETE FROM services WHERE id = $delete_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Service deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

$sql = "SELECT * FROM services";
$services = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #4fb4f8, #6d83f2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

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
            text-decoration: none; /* Button-like appearance */
            transition: background-color 0.3s, color 0.3s, transform 0.2s;
        }

        .return-btn:hover {
            background-color: #4fb4f8;
            color: white;
            transform: scale(1.05);
        }

        .return-btn:active {
            transform: scale(1);
        }

        .container {
            width: 90%;
            max-width: 800px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #4fb4f8;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input, textarea {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            font-size: 1rem;
            color: white;
            background: #4fb4f8;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #6d83f2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ccc;
            text-align: left;
            padding: 10px;
        }

        table th {
            background: #4fb4f8;
            color: white;
        }

        .delete-btn {
            color: red;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Back to Homepage Button -->
    <a href="index.html" class="return-btn">← Back to Homepage</a>

    <div class="container">
        <h1>Service Management</h1>

        <form method="POST">
            <input type="text" name="service_name" placeholder="Service Name" required>
            <textarea name="description" placeholder="Service Description" required></textarea>
            <input type="number" name="price" step="0.01" placeholder="Service Price" required>
            <button type="submit">Add Service</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Service Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($services->num_rows > 0) {
                while ($row = $services->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['service_name']}</td>
                            <td>{$row['description']}</td>
                            <td>\${$row['price']}</td>
                            <td>
                                <a href='?delete_id={$row['id']}' class='delete-btn'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No services found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>

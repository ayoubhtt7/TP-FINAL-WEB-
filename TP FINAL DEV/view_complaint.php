<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaints_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM complaints";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Complaints</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff5c77, #ffc371);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: backgroundAnimation 8s infinite alternate;
        }

        @keyframes backgroundAnimation {
            0% { background: linear-gradient(135deg, #ff5c77, #ffc371); }
            100% { background: linear-gradient(135deg, #ffc371, #ff5c77); }
        }

        .return-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 15px;
            background-color: white;
            color: #ff5c77;
            border: 2px solid #ff5c77;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none; /* Make it look like a button */
            transition: background-color 0.3s, color 0.3s, transform 0.2s;
        }

        .return-btn:hover {
            background-color: #ff5c77;
            color: white;
            transform: scale(1.05);
        }

        .return-btn:active {
            transform: scale(1);
        }

        /* Table Container */
        .container {
            background-color: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 900px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
            text-align: center;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 1rem;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        table th {
            background-color: #ff5c77;
            color: white;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #ffe5d2;
        }

        table td {
            color: #555;
        }

        /* No Complaints Row */
        table td[colspan] {
            text-align: center;
            font-size: 1.1rem;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- Back to Homepage Button -->
    <a href="index.html" class="return-btn">← Back to Homepage</a>

    <div class="container">
        <h1>Complaints Management</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Issue Type</th>
                <th>Severity</th>
                <th>Description</th>
                <th>Status</th>
                <th>Reply</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['client_name']}</td>
                            <td>{$row['issue_type']}</td>
                            <td>{$row['severity']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['status']}</td>
                            <td>" . (!empty($row['reply']) ? $row['reply'] : "No reply yet") . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No complaints found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>

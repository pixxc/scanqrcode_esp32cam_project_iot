<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$dbUsername = "root"; // Update with your DB username
$dbPassword = ""; // Update with your DB password
$dbname = "qrcodeweb"; // Your database name

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the scan_logs table
$sql = "SELECT id, username, room, scan_time, qrcode_data FROM scan_logs ORDER BY scan_time DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Scan Logs Monitoring</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a></p>
        </div>
        <div class="right-links">
            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>
<table class="content-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Room</th>
                <th>Scan Time</th>
                <th>QR Code</th> <!-- Changed column name to QR Code -->
            </tr>
        </thead>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                if (empty($row['username']) || empty($row['room']) || empty($row['qrcode_data'])) {
                    continue;
                }
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['room'] . "</td>";
                echo "<td>" . $row['scan_time'] . "</td>";

                // Display the QR code image using the qrcode2.php script
                $qrcode_data = urlencode($row['qrcode_data']); // URL encode to ensure safe URL format
                echo "<td><img src='qrcode2.php?qrcode_data=$qrcode_data' alt='QR Code' width='100' height='100'></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        ?>
</table>
</body>
</html>
<?php
$conn->close();
?>

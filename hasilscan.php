<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve the QR code data sent from the ESP32
if (isset($_POST['qrcode_data'])) {
    $qrcodeData = $_POST['qrcode_data'];

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

    // Split the QR code data into username and room
    list($username, $room) = explode(":", $qrcodeData);

    // Debugging: Log received data
    echo "Received Username: $username, Room: $room, QR Code Data: $qrcodeData<br>";

    // Prepare the SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO scan_logs (username, room, scan_time, qrcode_data) VALUES (?, ?, NOW(), ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters (username: string, room: integer, qrcode_data: string)
    $stmt->bind_param("sis", $username, $room, $qrcodeData);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "QR Code data saved successfully!";
    } else {
        echo "Execution Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "No QR code data received!";
}
?>

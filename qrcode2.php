<?php
// Include the QR Code library
require('phpqrcode/qrlib.php');
include('php/config.php'); // Database connection

if (isset($_GET['qrcode_data'])) {
    $qrcode_data = $_GET['qrcode_data']; // Get QR code data from URL parameter

    // Clean output buffer
    ob_clean();
    
    // Set header to indicate an image is being returned
    header('Content-Type: image/png');
    
    // Generate and output the QR code image
    QRcode::png($qrcode_data, null, QR_ECLEVEL_H, 5, 1); // Parameters for QR code: data, file output, error correction level, size, margin
    exit();
} else {
    // If no QR code data is provided
    header('Content-Type: text/plain');
    echo "No QR code data provided.";
}
?>

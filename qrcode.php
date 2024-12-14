<?php
require('phpqrcode/qrlib.php'); // Memanggil library PHP QR Code
include('php/config.php'); // File konfigurasi koneksi database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil username dan room
    $query = "SELECT username, room FROM users WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $room = $row['room'];

        // Gabungkan data
        $data = $username . ':' . $room;

        // Pastikan tidak ada output lain sebelum header
        ob_clean(); // Membersihkan buffer output
        header('Content-Type: image/png');

        // Generate QR Code
        QRcode::png($data, false, QR_ECLEVEL_H, 5, 1);
        exit();
    } else {
        // Jika data tidak ditemukan
        header('Content-Type: text/plain');
        echo "No data found for this ID.";
    }
} else {
    // Jika ID tidak ada
    header('Content-Type: text/plain');
    echo "ID parameter is missing.";
}

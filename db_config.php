<?php
// Konfigurasi Database
$db_host = 'localhost';
$db_user = 'username_db';
$db_pass = 'password_db';
$db_name = 'nama_database';

// Buat koneksi
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8");

// Fungsi query cepat
function quick_query($sql) {
    global $conn;
    $result = $conn->query($sql);
    if (!$result) die("Query error: " . $conn->error);
    return $result;
}
?>

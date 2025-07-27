<?php
// Fungsi keamanan
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

// Fungsi autentikasi
function check_login() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Format angka
function format_rupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

// Redirect cepat
function redirect($url) {
    header("Location: $url");
    exit();
}
?>

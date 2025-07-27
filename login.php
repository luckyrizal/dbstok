<?php
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);
    
    // Query langsung tanpa prepared statement (untuk kecepatan)
    $result = quick_query("SELECT id, password FROM users WHERE username = '$username'");
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            redirect('dashboard.php');
        }
    }
    
    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-box { max-width: 400px; margin: 100px auto; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="text-center mb-4">Login Sistem</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

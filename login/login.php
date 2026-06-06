<?php
session_start();
require_once "../assets/style.css";

if (isset($_SESSION['user'])){
    if ($_SESSION['role'] == 'admin'){
        header("Location: ../admin/dashboard.php");
    }else{
        header("Location: ../user/dashboarduser.php");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>

<div class="login-page">
    <div class="login-card">
        <div class="logo">
            <div class="logo-icon">&#128230;</div>
            <h1>Sistem Inventaris</h1>
            <p>Manajemen Barang Digital</p>
        </div>

        <!-- Contoh pesan error (tampilkan jika login gagal) -->
        <!-- <div class="alert alert-danger">Username atau password salah.</div> -->

        <form action="../scripts/script.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>

        <p style="text-align:center; margin-top:16px; font-size:12px; color:#94a3b8;">
            Sistem Inventaris Barang v1.0
        </p>
    </div>
</div>

</body>
</html>
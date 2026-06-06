<?php
require_once "../login/auth.php";
require_once "../assets/style.css";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Sistem Inventaris</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">&#128230;</div>
        <div class="brand-text">INVENTARIS<span>Sistem Manajemen Barang</span></div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-title">Menu Utama</div>
        <a href="dashboard.php" class="nav-item"><span class="nav-icon">&#128200;</span><span class="nav-label">Dashboard</span></a>
        <a href="barang.php" class="nav-item"><span class="nav-icon">&#128230;</span><span class="nav-label">Data Barang</span></a>
        <a href="kategori.php" class="nav-item active"><span class="nav-icon">&#127991;</span><span class="nav-label">Kategori</span></a>
        <a href="riwayat.php" class="nav-item"><span class="nav-icon">&#128203;</span><span class="nav-label">Riwayat</span></a>
        <div class="nav-section-title">Admin</div>
        <a href="user.php" class="nav-item"><span class="nav-icon">&#128101;</span><span class="nav-label">Kelola User</span></a>
    </nav>
    <div class="sidebar-toggle" onclick="toggleSidebar()">
        <span class="nav-icon" id="toggleIcon">&#9664;</span>
        <span class="nav-label">Ciutkan</span>
    </div>
</div>

<div class="header" id="mainHeader">
    <div class="header-title">Tambah Kategori</div>
    <div class="header-right">
        <div class="user-info">
            <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['user'], 0, 1)); ?></div>
            <div class="user-detail">
                <div class="user-name"><?php echo $_SESSION['user']; ?></div>
                <div class="user-role">
                    <span class="badge-role <?php echo $_SESSION['role']; ?>"><?php echo ucfirst($_SESSION['role']); ?></span>
                </div>
            </div>
        </div>
        <a href="login.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</div>

<div class="main-content" id="mainContent">
    <div class="page-header">
        <div>
            <h2>Tambah Kategori</h2>
            <p>Tambah kategori barang baru</p>
        </div>
        <a href="kategori.php" class="btn btn-outline">Kembali</a>
    </div>

    <div class="card" style="max-width:500px;">
        <form action="../scripts/tambahkategori.php" method="POST">
            <div class="form-group">
                <label>Nama Kategori *</label>
                <input type="text" name="nama_kategori" placeholder="Contoh: Elektronik" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" placeholder="Deskripsi kategori (opsional)"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const header  = document.getElementById('mainHeader');
        const content = document.getElementById('mainContent');
        const icon    = document.getElementById('toggleIcon');
        sidebar.classList.toggle('collapsed');
        header.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
        icon.innerHTML = sidebar.classList.contains('collapsed') ? '&#9654;' : '&#9664;';
    }
</script>
</body>
</html>

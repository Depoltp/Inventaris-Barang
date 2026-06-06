<?php
require_once "../login/auth.php";
require_once "../assets/style.css";
require_once "../config/db.php";

$sql = "SELECT * FROM users ORDER BY id_user ASC";

$result = $conn->query($sql);

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
    <title>Kelola User - Sistem Inventaris</title>
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
        <a href="kategori.php" class="nav-item"><span class="nav-icon">&#127991;</span><span class="nav-label">Kategori</span></a>
        <a href="riwayat.php" class="nav-item"><span class="nav-icon">&#128203;</span><span class="nav-label">Riwayat</span></a>
        <div class="nav-section-title">Admin</div>
        <a href="user.php" class="nav-item active"><span class="nav-icon">&#128101;</span><span class="nav-label">Kelola User</span></a>
    </nav>
    <div class="sidebar-toggle" onclick="toggleSidebar()">
        <span class="nav-icon" id="toggleIcon">&#9664;</span>
        <span class="nav-label">Ciutkan</span>
    </div>
</div>

<div class="header" id="mainHeader">
    <div class="header-title">Kelola User</div>
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
        <a href="../login/logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</div>

<div class="main-content" id="mainContent">
    <div class="page-header">
        <div>
            <h2>Kelola User</h2>
            <p>Tambah dan hapus akun pengguna sistem</p>
        </div>
    </div>

    <div class="grid-2">
        <!-- Form Tambah User -->
        <div class="card">
            <div class="card-header">
                <h3>Tambah User Baru</h3>
            </div>
            <form action="../scripts/tambahuser.php" method="POST">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" placeholder="Nama lengkap user" required>
                </div>
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" placeholder="Username untuk login" required>
                </div>
                <div class="form-group">
                    <label>Password * (min. 6 karakter)</label>
                    <input type="password" name="password" placeholder="Password" required minlength="6">
                </div>
                <div class="form-group">
                    <label>Role *</label>
                    <select name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tambah User</button>
            </form>
        </div>

        <!-- Daftar User -->
        <div class="card">
            <div class="card-header">
                <h3>Daftar User</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($user = $result->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $user['id_user']; ?></td>
                            <td><?php echo $user['nama_lengkap']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td>
                                <span class="badge-role <?php echo $user['role']; ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if($user['username'] == $_SESSION['user']){ ?>
                                    <span style="color:#94a3b8; font-size:12px;">
                                        Anda
                                    </span>
                                <?php }else{ ?>
                                    <a href="../scripts/hapususer.php?id=<?php echo $user['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus user ini?')">
                                    Hapus
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
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

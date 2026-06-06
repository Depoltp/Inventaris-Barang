<?php
require_once "../login/auth.php";
require_once "../assets/style.css";
require_once "../config/db.php";

if ($_SESSION['role'] != 'user'){
    echo "Access Denied!";
    exit;
}

$q_barang = "SELECT COUNT(*) AS total_barang FROM barang";
$total_barang = $conn
    ->query($q_barang)
    ->fetch_assoc()['total_barang'];

$q_kategori = "SELECT COUNT(*) AS total_kategori FROM kategori";
$total_kategori = $conn
    ->query($q_kategori)
    ->fetch_assoc()['total_kategori'];

$q_user = "SELECT COUNT(*) AS total_user FROM users";
$total_user = $conn
    ->query($q_user)
    ->fetch_assoc()['total_user'];

$q_low = "SELECT COUNT(*) AS total_low FROM barang WHERE stok < 10";
$total_low = $conn
    ->query($q_low)
    ->fetch_assoc()['total_low'];

$q_low_items = "SELECT * FROM barang WHERE stok < 10 ORDER BY stok ASC";
$low_items = $conn->query($q_low_items);

$q_riwayat = "SELECT riwayat.*, barang.nama_barang FROM riwayat JOIN barang ON riwayat.id_barang = barang.id_barang ORDER BY tanggal DESC LIMIT 10";
$riwayat_terbaru = $conn->query($q_riwayat);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Inventaris</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">&#128230;</div>
        <div class="brand-text">
            INVENTARIS
            <span>Sistem Manajemen Barang</span>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-title">Menu Utama</div>
        <a href="dashboarduser.php" class="nav-item active">
            <span class="nav-icon">&#128200;</span>
            <span class="nav-label">Dashboard</span>
        </a>
        <a href="baranguser.php" class="nav-item">
            <span class="nav-icon">&#128230;</span>
            <span class="nav-label">Data Barang</span>
        </a>
        <a href="kategoriuser.php" class="nav-item">
            <span class="nav-icon">&#127991;</span>
            <span class="nav-label">Kategori</span>
        </a>
        <a href="riwayatuser.php" class="nav-item">
            <span class="nav-icon">&#128203;</span>
            <span class="nav-label">Riwayat</span>
        </a>
    </nav>
    <div class="sidebar-toggle" onclick="toggleSidebar()">
        <span class="nav-icon" id="toggleIcon">&#9664;</span>
        <span class="nav-label">Ciutkan</span>
    </div>
</div>

<!-- HEADER -->
<div class="header" id="mainHeader">
    <div class="header-title">Dashboard</div>
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

<!-- MAIN CONTENT -->
<div class="main-content" id="mainContent">

    <!-- Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">&#128230;</div>
            <div class="stat-info">
                <div class="stat-value"><?php echo $total_barang; ?></div>
                <div class="stat-label">Total Barang</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">&#127991;</div>
            <div class="stat-info">
                <div class="stat-value"><?php echo $total_kategori; ?></div>
                <div class="stat-label">Total Kategori</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">&#9888;</div>
            <div class="stat-info">
                <div class="stat-value"><?php echo $total_low; ?></div>
                <div class="stat-label">Stok Rendah</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">&#128101;</div>
            <div class="stat-info">
                <div class="stat-value"><?php echo $total_user; ?></div>
                <div class="stat-label">Total User</div>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <!-- Stok Rendah -->
        <div class="card">
            <div class="card-header">
                <h3>&#9888; Peringatan Stok Rendah</h3>
                <a href="baranguser.php" class="btn btn-outline btn-sm">Lihat Semua</a>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($low_items->num_rows > 0){
                        while ($barang = $low_items->fetch_assoc()){
                            if ($barang['stok'] == 0){
                                $badge = "danger";
                                $status = "Habis";
                            }else{
                                $badge = "warning";
                                $status = "Menipis";
                            }
                    ?>
                        <tr>
                            <td>
                                <?php echo $barang['nama_barang']; ?>
                            </td>
                            <td>
                                <?php echo $barang['stok']; ?>
                                <?php echo $barang['satuan']; ?>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $badge; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                        </tr>
                    <?php
                        }
                    }else{
                    ?>
                        <tr>
                            <td colspan="3" style="text-align:center;">
                                Tidak ada stok rendah
                            </td>
                        </tr>
                    <?php
                    } 
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Riwayat Terbaru -->
        <div class="card">
            <div class="card-header">
                <h3>&#128203; Riwayat Terbaru</h3>
                <a href="riwayatuser.php" class="btn btn-outline btn-sm">Lihat Semua</a>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($riwayat_terbaru->num_rows > 0){
                            while ($row = $riwayat_terbaru->fetch_assoc()){
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['nama_barang']; ?>
                            </td>
                            <td>
                                <?php
                                if ($row['jenis'] == 'masuk'){
                                ?>
                                    <span class="badge badge-success">
                                        Masuk
                                    </span>
                                <?php
                                }else{
                                ?>
                                    <span class="badge badge-danger">
                                        Keluar
                                    </span>
                                <?php
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo $row['jumlah']; ?>
                            </td>
                        </tr>
                        <?php
                            }
                        }else{
                        ?>
                            <tr>
                                <td colspan="3" style="text-align:center;">
                                    Belum ada transaksi
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
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

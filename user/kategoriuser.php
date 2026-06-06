<?php
require_once "../login/auth.php";
require_once "../assets/style.css";
require_once "../config/db.php";

if ($_SESSION['role'] != 'user'){
    echo "Access Denied!";
    exit;
}

$sql = "SELECT kategori.*, COUNT(barang.id_barang) AS total_barang FROM kategori LEFT JOIN barang ON kategori.id_kategori = barang.id_kategori GROUP BY kategori.id_kategori ORDER BY kategori.id_kategori ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - Sistem Inventaris</title>
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
        <a href="dashboarduser.php" class="nav-item"><span class="nav-icon">&#128200;</span><span class="nav-label">Dashboard</span></a>
        <a href="baranguser.php" class="nav-item"><span class="nav-icon">&#128230;</span><span class="nav-label">Data Barang</span></a>
        <a href="kategoriuser.php" class="nav-item active"><span class="nav-icon">&#127991;</span><span class="nav-label">Kategori</span></a>
        <a href="riwayatuser.php" class="nav-item"><span class="nav-icon">&#128203;</span><span class="nav-label">Riwayat</span></a>
    </nav>
    <div class="sidebar-toggle" onclick="toggleSidebar()">
        <span class="nav-icon" id="toggleIcon">&#9664;</span>
        <span class="nav-label">Ciutkan</span>
    </div>
</div>

<div class="header" id="mainHeader">
    <div class="header-title">Kategori</div>
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
            <h2>Data Kategori</h2>
            <p>Kelola kategori barang inventaris</p>
        </div>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Barang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0){ ?>
                        <?php while($kategori = $result->fetch_assoc()){ ?>
                        <tr>
                            <td>
                                <?php echo $kategori['id_kategori']; ?>
                            </td>
                            <td>
                                <?php echo $kategori['nama_kategori']; ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($kategori['deskripsi'])){
                                    echo $kategori['deskripsi'];
                                }else{
                                    echo "-";
                                }
                                ?>
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    <?php echo $kategori['total_barang']; ?>
                                    barang
                                </span>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php }else{ ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">
                            Belum ada kategori
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
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

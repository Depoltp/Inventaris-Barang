<?php
require_once "../login/auth.php";
require_once "../assets/style.css";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}

$search = "";
if (isset($_GET['search'])){
    $search = $_GET['search'];
    $sql = "SELECT barang.*, kategori.nama_kategori FROM barang JOIN kategori ON barang.id_kategori = kategori.id_kategori WHERE nama_barang LIKE ? OR kode_barang LIKE ? ORDER BY id_barang ASC";
    $stmt = $conn->prepare($sql);
    $keyword = "%" . $search . "%";
    $stmt->bind_param("ss", $keyword, $keyword);
    $stmt->execute();
    $result = $stmt->get_result();
}else{
    $sql = "SELECT barang.*, kategori.nama_kategori FROM barang JOIN kategori ON barang.id_kategori = kategori.id_kategori ORDER BY id_barang ASC";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Sistem Inventaris</title>
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
        <a href="barang.php" class="nav-item active"><span class="nav-icon">&#128230;</span><span class="nav-label">Data Barang</span></a>
        <a href="kategori.php" class="nav-item"><span class="nav-icon">&#127991;</span><span class="nav-label">Kategori</span></a>
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
    <div class="header-title">Data Barang</div>
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
            <h2>Data Barang</h2>
            <p>Kelola semua data barang inventaris</p>
        </div>
        <a href="barang-tambah.php" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    <!-- Contoh alert sukses -->
    <!-- <div class="alert alert-success">Barang berhasil ditambahkan.</div> -->

    <div class="card">
        <form class="search-bar" method="GET">
            <input type="text" name="search" placeholder="Cari nama atau kode barang..." value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0) { ?>
                        <?php while($barang = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $barang['id_barang']; ?></td>
                            <td>
                                <code>
                                    <?php echo $barang['kode_barang']; ?>
                                </code>
                            </td>
                            <td><?php echo $barang['nama_barang']; ?></td>
                            <td><?php echo $barang['nama_kategori']; ?></td>
                            <td>
                                <?php
                                if ($barang['stok'] > 5){
                                    $badge = "success";
                                }elseif ($barang['stok'] > 0){
                                    $badge = "warning";
                                }else{
                                    $badge = "danger";
                                }
                                ?>
                                <span class="badge badge-<?php echo $badge; ?>">
                                    <?php echo $barang['stok']; ?> unit
                                </span>
                            </td>
                            <td>
                                <?php
                                $kondisi_class = "success";
                                if (strtolower($barang['kondisi']) == "rusak ringan"){
                                    $kondisi_class = "warning";
                                }elseif (strtolower($barang['kondisi']) == "rusak berat"){
                                    $kondisi_class = "danger";
                                }
                                ?>
                                <span class="badge badge-<?php echo $kondisi_class; ?>">
                                    <?php echo $barang['kondisi']; ?>
                                </span>
                            </td>
                            <td><?php echo $barang['lokasi']; ?></td>
                            <td>
                                <div class="action-btns">
                                    <a href="barang-edit.php?id=<?php echo $barang['id_barang']; ?>"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                    </a>
                                    <a href="../scripts/hapusbarang.php?id=<?php echo $barang['id_barang']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus barang ini?')">
                                    Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php }else{ ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">
                            Barang tidak ditemukan
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

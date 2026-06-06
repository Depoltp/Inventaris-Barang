<?php
require_once "../login/auth.php";
require_once "../assets/style.css";
require_once "../config/db.php";

if ($_SESSION['role'] != 'user'){
    echo "Access Denied!";
    exit;
}

$sql_barang = "SELECT * FROM barang ORDER BY nama_barang ASC";
$result_barang = $conn->query($sql_barang);

$sql_riwayat = "SELECT riwayat.*, barang.nama_barang, barang.satuan, users.username FROM riwayat JOIN barang ON riwayat.id_barang = barang.id_barang JOIN users ON riwayat.id_user = users.id_user ORDER BY riwayat.tanggal DESC LIMIT 50";
$result_riwayat = $conn->query($sql_riwayat);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat - Sistem Inventaris</title>
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
        <a href="kategoriuser.php" class="nav-item"><span class="nav-icon">&#127991;</span><span class="nav-label">Kategori</span></a>
        <a href="riwayatuser.php" class="nav-item active"><span class="nav-icon">&#128203;</span><span class="nav-label">Riwayat</span></a>
    </nav>
    <div class="sidebar-toggle" onclick="toggleSidebar()">
        <span class="nav-icon" id="toggleIcon">&#9664;</span>
        <span class="nav-label">Ciutkan</span>
    </div>
</div>

<div class="header" id="mainHeader">
    <div class="header-title">Riwayat Barang</div>
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
            <h2>Riwayat Barang</h2>
            <p>Catat dan lihat riwayat barang masuk dan keluar</p>
        </div>
    </div>

    <!-- Form Catat Transaksi -->
    <div class="card" style="margin-bottom:20px;">
        <div class="card-header">
            <h3>Catat Transaksi Baru</h3>
        </div>
        <form action="../scripts/tambahriwayat.php" method="POST">
            <div class="grid-2">
                <div class="form-group">
                    <label>Barang *</label>
                    <select name="barang_id" required>
                        <option value="">
                            -- Pilih Barang --
                        </option>
                        <?php while($barang = $result_barang->fetch_assoc()) { ?>
                            <option value="<?php echo $barang['id_barang']; ?>">
                                <?php echo $barang['nama_barang']; ?>
                                (Stok:<?php echo $barang['stok']; ?> <?php echo $barang['satuan']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis *</label>
                    <select name="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="masuk">Barang Masuk</option>
                        <option value="keluar">Barang Keluar</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah *</label>
                    <input type="number" name="jumlah" min="1" placeholder="Masukkan jumlah">
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" placeholder="Keterangan (opsional)">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        </form>
    </div>

    <!-- Tabel Riwayat -->
    <div class="card">
        <div class="card-header">
            <h3>Riwayat Transaksi (50 Terbaru)</h3>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Oleh</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result_riwayat->num_rows > 0){ ?>
                        <?php while($riwayat = $result_riwayat->fetch_assoc()){ ?>
                        <tr>
                            <td>
                                <?php echo $riwayat['id_riwayat']; ?>
                            </td>
                            <td>
                                <?php
                                echo date(
                                    "d/m/Y H:i",
                                    strtotime($riwayat['tanggal'])
                                );
                                ?>
                            </td>
                            <td>
                                <?php echo $riwayat['nama_barang']; ?>
                            </td>
                            <td>
                                <?php
                                if ($riwayat['jenis'] == 'masuk'){
                                    $badge = "success";
                                    $text = "Masuk";
                                }else{
                                    $badge = "danger";
                                    $text = "Keluar";
                                }
                                ?>
                                <span class="badge badge-<?php echo $badge; ?>">
                                    <?php echo $text; ?>
                                </span>
                            </td>
                            <td>
                                <?php echo $riwayat['jumlah']; ?>
                            </td>
                            <td>
                                <?php echo $riwayat['username']; ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($riwayat['keterangan'])){
                                    echo $riwayat['keterangan'];
                                }else{
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php }else{ ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">
                            Belum ada riwayat transaksi
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

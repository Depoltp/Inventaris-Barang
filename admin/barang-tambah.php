<?php
require_once "../login/auth.php";
require_once "../assets/style.css";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}

$sql_kategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$result_kategori = $conn->query($sql_kategori);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Sistem Inventaris</title>
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
    <div class="header-title">Tambah Barang</div>
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
            <h2>Tambah Barang</h2>
            <p>Tambah data barang baru ke inventaris</p>
        </div>
        <a href="barang.php" class="btn btn-outline">Kembali</a>
    </div>

    <!-- <div class="alert alert-danger">Kode barang sudah digunakan.<br>Nama barang wajib diisi.</div> -->

    <div class="card">
        <form action="../scripts/tambahbarang.php" method="POST">
            <div class="grid-2">
                <div class="form-group">
                    <label>Kode Barang *</label>
                    <input type="text" name="kode_barang" placeholder="Contoh: BRG-007" required>
                </div>
                <div class="form-group">
                    <label>Nama Barang *</label>
                    <input type="text" name="nama_barang" placeholder="Nama barang" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" required>
                        <option value="">
                            -- Pilih Kategori --
                        </option>
                        <?php while($kategori = $result_kategori->fetch_assoc()){ ?>
                            <option value="<?php echo $kategori['id_kategori']; ?>">
                                <?php echo $kategori['nama_kategori']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kondisi *</label>
                    <select name="kondisi" required>
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" name="stok" min="0" value="0" required>
                </div>
                <div class="form-group">
                    <label>Satuan *</label>
                    <input type="text" name="satuan" placeholder="pcs / unit / rim / dll" value="pcs">
                </div>
                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" placeholder="Contoh: Gudang A">
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" placeholder="Keterangan tambahan (opsional)"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Barang</button>
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

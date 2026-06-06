<?php
require_once "../login/auth.php";
require_once "../assets/style.css";
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID barang tidak ditemukan!";
    exit;
}
$id_barang = $_GET['id'];

$sql_barang = "SELECT * FROM barang WHERE id_barang = ?";
$stmt_barang = $conn->prepare($sql_barang);
$stmt_barang->bind_param("i", $id_barang);
$stmt_barang->execute();
$result_barang = $stmt_barang->get_result();

if ($result_barang->num_rows == 0){
    echo "Barang tidak ditemukan!";
    exit;
}
$barang = $result_barang->fetch_assoc();

$sql_kategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$result_kategori = $conn->query($sql_kategori);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Sistem Inventaris</title>
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
    <div class="header-title">Edit Barang</div>
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
            <h2>Edit Barang</h2>
            <p>Perbarui data barang: <?php echo $barang['nama_barang']; ?></p>
        </div>
        <a href="barang.php" class="btn btn-outline">Kembali</a>
    </div>

    <div class="card">
        <form action="../scripts/editbarang.php?id=<?php echo $barang['id_barang']; ?>" method="POST">
            <div class="grid-2">
                <div class="form-group">
                    <label>Kode Barang *</label>
                    <input type="text" name="kode_barang"  value="<?php echo $barang['kode_barang']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama Barang *</label>
                    <input type="text" name="nama_barang" value="<?php echo $barang['nama_barang']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" required>
                        <option value="">
                            -- Pilih Kategori --
                        </option>
                        <?php while($kategori = $result_kategori->fetch_assoc()){ ?>
                            <option value="<?php echo $kategori['id_kategori']; ?>"
                                <?php
                                if ($kategori['id_kategori'] == $barang['id_kategori']){
                                    echo "selected";
                                } ?>>
                                <?php echo $kategori['nama_kategori']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kondisi *</label>
                    <select name="kondisi" required>
                        <option value="baik"
                            <?php
                            if ($barang['kondisi'] == 'baik'){
                                echo "selected";
                            } ?>>
                            Baik
                        </option>
                        <option value="rusak_ringan"
                            <?php
                            if ($barang['kondisi'] == 'rusak_ringan'){
                                echo "selected";
                            } ?>>
                            Rusak Ringan
                        </option>
                        <option value="rusak_berat"
                            <?php
                            if ($barang['kondisi'] == 'rusak_berat'){
                                echo "selected";
                            } ?>>
                            Rusak Berat
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" name="stok" min="0" value="<?php echo $barang['stok']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Satuan *</label>
                    <input type="text" name="satuan" value="<?php echo $barang['satuan']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" value="<?php echo $barang['lokasi']; ?>">
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" value="<?php echo $barang['keterangan']; ?>"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

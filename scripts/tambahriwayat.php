<?php
session_start();
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}

$id_barang  = $_POST['barang_id'];
$jenis      = $_POST['jenis'];
$jumlah     = $_POST['jumlah'];
$keterangan = $_POST['keterangan'];

$id_user = $_SESSION['id_user'];

if ($jumlah <= 0){
    echo "Jumlah transaksi tidak valid!";
    exit;
}

$sql_barang = "SELECT * FROM barang WHERE id_barang = ?";
$stmt_barang = $conn->prepare($sql_barang);
$stmt_barang->bind_param(
    "i",
    $id_barang
);
$stmt_barang->execute();
$result_barang = $stmt_barang->get_result();

if ($result_barang->num_rows == 0) {
    echo "Barang tidak ditemukan!";
    exit;
}
$barang = $result_barang->fetch_assoc();
$current_stok = $barang['stok'];

if ($jenis == 'masuk'){
    $new_stok = $current_stok + $jumlah;
}elseif ($jenis == 'keluar'){
    if ($jumlah > $current_stok){
        echo "Stok tidak mencukupi!";
        exit;
    }
    $new_stok = $current_stok - $jumlah;
}else{
    echo "Jenis transaksi tidak valid!";
    exit;
}

$sql_update = "UPDATE barang SET stok = ? WHERE id_barang = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param(
    "ii",
    $new_stok,
    $id_barang
);

$sql_riwayat = "INSERT INTO riwayat (id_barang, id_user, jenis, jumlah, keterangan) VALUES (?, ?, ?, ?, ?)";
$stmt_riwayat = $conn->prepare($sql_riwayat);
$stmt_riwayat->bind_param(
    "iisis",
    $id_barang,
    $id_user,
    $jenis,
    $jumlah,
    $keterangan
);

if ($stmt_update->execute() && $stmt_riwayat->execute()){
    header("Location: ../admin/riwayat.php");
    exit;
}else{
    echo "Gagal menyimpan transaksi!";
}
?>
<?php
session_start();
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}

if (!isset($_GET['id'])){
    echo "ID barang tidak ditemukan!";
    exit;
}
$id_barang = $_GET['id'];

$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$kategori_id = $_POST['kategori_id'];
$kondisi     = $_POST['kondisi'];
$stok        = $_POST['stok'];
$satuan      = $_POST['satuan'];
$lokasi      = $_POST['lokasi'];
$keterangan  = $_POST['keterangan'];

$check = "SELECT * FROM barang WHERE kode_barang = ? AND id_barang != ?";
$stmt_check = $conn->prepare($check);
$stmt_check->bind_param(
    "si",
    $kode_barang,
    $id_barang
);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
if ($result_check->num_rows > 0){
    echo "Kode barang sudah digunakan!";
    exit;
}

$sql = "UPDATE barang SET kode_barang = ?, nama_barang = ?, stok = ?, satuan = ?, kondisi = ?, lokasi = ?, keterangan = ?, id_kategori = ? WHERE id_barang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssissssii",
    $kode_barang,
    $nama_barang,
    $stok,
    $satuan,
    $kondisi,
    $lokasi,
    $keterangan,
    $kategori_id,
    $id_barang
);
if ($stmt->execute()){
    header("Location: ../admin/barang.php");
    exit;
}else{
    echo "Gagal memperbarui barang!";
}
?>
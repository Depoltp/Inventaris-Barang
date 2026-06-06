<?php
session_start();
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}

$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$kategori_id = $_POST['kategori_id'];
$kondisi     = $_POST['kondisi'];
$stok        = $_POST['stok'];
$satuan      = $_POST['satuan'];
$lokasi      = $_POST['lokasi'];
$keterangan  = $_POST['keterangan'];

$id_user = $_SESSION['id_user'];

$check = "SELECT * FROM barang WHERE kode_barang = ?";
$stmt_check = $conn->prepare($check);
$stmt_check->bind_param("s", $kode_barang);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0){
    echo "Kode barang sudah digunakan!";
    exit;
}

$sql = "INSERT INTO barang(kode_barang, nama_barang, stok, satuan, kondisi, lokasi, keterangan, tanggal_masuk, id_kategori, id_user) VALUES(?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
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
    $id_user
);

if ($stmt->execute()){
    header("Location: ../admin/barang.php");
    exit;
}else{
    echo "Gagal menambahkan barang!";
}
?>
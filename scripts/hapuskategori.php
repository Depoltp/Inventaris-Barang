<?php
session_start();
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}

if (!isset($_GET['id'])){
    echo "ID kategori tidak ditemukan!";
    exit;
}
$id_kategori = $_GET['id'];

$check_kategori = "SELECT * FROM kategori WHERE id_kategori = ?";
$stmt_kategori = $conn->prepare($check_kategori);
$stmt_kategori->bind_param(
    "i",
    $id_kategori
);
$stmt_kategori->execute();
$result_kategori = $stmt_kategori->get_result();

if ($result_kategori->num_rows == 0) {
    echo "Kategori tidak ditemukan!";
    exit;
}

$check_barang = "SELECT * FROM barang WHERE id_kategori = ?";
$stmt_barang = $conn->prepare($check_barang);
$stmt_barang->bind_param(
    "i",
    $id_kategori
);
$stmt_barang->execute();
$result_barang = $stmt_barang->get_result();

if ($result_barang->num_rows > 0) {
    echo "Kategori tidak dapat dihapus karena masih digunakan oleh barang!";
    exit;
}

$sql = "DELETE FROM kategori WHERE id_kategori = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "i",
    $id_kategori
);
if ($stmt->execute()){
    header("Location: ../admin/kategori.php");
    exit;
}else{
    echo "Gagal menghapus kategori!";
}
?>
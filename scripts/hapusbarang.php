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

$sql = "DELETE FROM barang WHERE id_barang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_barang);
if ($stmt->execute()){
    header("Location: ../admin/barang.php");
    exit;
}else{
    echo "Gagal menghapus barang!";
}
?>
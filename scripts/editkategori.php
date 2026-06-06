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

$nama_kategori = $_POST['nama_kategori'];
$deskripsi     = $_POST['deskripsi'];

$check = "SELECT * FROM kategori WHERE nama_kategori = ? AND id_kategori != ?";
$stmt_check = $conn->prepare($check);
$stmt_check->bind_param(
    "si",
    $nama_kategori,
    $id_kategori
);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0){
    echo "Nama kategori sudah digunakan!";
    exit;
}

$sql = "UPDATE kategori SET nama_kategori = ?, deskripsi = ? WHERE id_kategori = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssi",
    $nama_kategori,
    $deskripsi,
    $id_kategori
);
if ($stmt->execute()){
    header("Location: ../admin/kategori.php");
    exit;
}else{
    echo "Gagal memperbarui kategori!";
}
?>
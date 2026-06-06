<?php
session_start();
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}

$nama_kategori = $_POST['nama_kategori'];
$deskripsi     = $_POST['deskripsi'];

$check = "SELECT * FROM kategori WHERE nama_kategori = ?";
$stmt_check = $conn->prepare($check);
$stmt_check->bind_param(
    "s",
    $nama_kategori
);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0){
    echo "Kategori sudah ada!";
    exit;
}

$sql = "INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ss",
    $nama_kategori,
    $deskripsi
);
if ($stmt->execute()){
    header("Location: ../admin/kategori.php");
    exit;
}else{
    echo "Gagal menambahkan kategori!";
}
?>
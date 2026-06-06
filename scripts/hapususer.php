<?php
session_start();
require_once "../config/db.php";

if ($_SESSION['role'] != 'admin'){
    echo "Access Denied!";
    exit;
}

if (!isset($_GET['id'])){
    echo "User ID tidak ditemukan!";
    exit;
}
$id = $_GET['id'];

if ($id == $_SESSION['id_user']){
    echo "Failed!";
    exit;
}

$sql = "DELETE FROM users WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
if ($stmt->execute()){
    header("Location: ../admin/user.php");
    exit;
}else{
    echo "Failed!";
}
?>
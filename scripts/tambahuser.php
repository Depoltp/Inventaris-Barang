<?php

require_once "../config/db.php";

$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];
// HASH PASSWORD
//$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$check = "SELECT * FROM users WHERE username = ?";
$stmt_check = $conn->prepare($check);
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$result = $stmt_check->get_result();
if ($result->num_rows > 0){
    echo "Username not available!";
    exit;
}

$sql = "INSERT INTO users
(nama_lengkap, username, password, role)
VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssss",
    $nama,
    $username,
    $password,
    $role
);
if ($stmt->execute()){
    header("Location: ../admin/user.php");
    exit;
}else{
    echo "Failed!";
}
?>
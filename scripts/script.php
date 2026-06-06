<?php
session_start();

require_once "../config/db.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0){
    $user = $result->fetch_assoc();
    if ($password == $user['password']){
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['id_user'] = $user['id_user'];
        if ($user['role'] == 'admin'){
            header("Location: ../admin/dashboard.php");
        }else{
            header("Location: ../user/dashboarduser.php");
        }
        exit;
    }else{
        echo "Invalid Password";
    }
}else{
    echo "Invalid User";
}
?>
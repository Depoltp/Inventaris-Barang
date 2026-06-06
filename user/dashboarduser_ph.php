<?php
require_once "../login/auth.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard User</title>
</head>
<body>
    <h1>Dashboard User</h1>
    <p>Anda telah log in sebagai <?php echo $_SESSION['user'];?></p>
    <a href="../login/logout.php">Logout</a>
</body>
</html>
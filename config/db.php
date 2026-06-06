<?php

$host = "localhost";
$dbname = "inventaris_barang";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error){
    die("Connection to db failed" . $conn->connect_error);
}
?>
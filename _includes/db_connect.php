<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'database_botany';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>

<!-- 
$db_host = 'sql302.infinityfree.com';
$db_user = 'if0_39439295';
$db_pass = 'BotanyAcademy1';
$db_name = 'if0_39439295_database_botany'; 
-->
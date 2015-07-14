<?php 
$user='root';   // user dari database saya
$server='localhost'; // name server
$pass='Albarbasy'; // password database
$database='ujian_online_db'; // nama database
mysql_connect($server,$user, $pass) or die('koneksi gagal');
mysql_select_db($database) or die('database tidak ditemukan');
?>

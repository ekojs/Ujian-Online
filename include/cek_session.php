<?php 
session_start();
if(!isset($_SESSION['login_kj'])){
	header("location:index.php?info=Harus login dulu kawan...");
	}
?>

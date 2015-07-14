<?php
session_start();
include_once "include/koneksi.php";
$id_user = $_SESSION['nis_kj'];
$status = 0;
$pass_lama = md5($_REQUEST['pass_lama']);
$pass_baru = md5($_REQUEST['pass_baru']);
// cek apakah password lama sudah benar
$pass_lama_db = mysql_result(mysql_query("select password from user where id_user='".$id_user."'"),0);
if($pass_lama_db == $pass_lama){
	$update_pass = mysql_query("update user set password='".$pass_baru."' where id_user='".$id_user."'");
	if($update_pass){
	$status = 1;
	}
	}
else {
	$status = "Password lama tidak sama, cek kembali ...";
	}	
echo $status;	
?>

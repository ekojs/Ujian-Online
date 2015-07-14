<?php
/*---------------------------------------------------------------------
 hapus nilai ujian siswa xxx pada id_ujian yyy agar siswa bisa mengulang ujian tersebut
 ---------------------------------------------------------------------*/ 
include_once "include/koneksi.php"; 
$status = 0;
$nis = $_REQUEST['nis'];
$id_ujian = $_REQUEST['id_ujian'];
$table = "nilai";
$sql = "delete from ".$table." where id_user='".$nis."' and id_ujian='".$id_ujian."'";
$sql_exe = mysql_query($sql);
if($sql_exe){
	$status = 1;
	}
echo $status;	
?>

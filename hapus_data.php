<?php
/*---------------------------------------------------------------------
 hapus data pada tabel berdasarkan primary key 
 ---------------------------------------------------------------------*/ 
include_once "include/koneksi.php"; 
$status = 0;
$id_nilai = $_REQUEST['id_nilai'];
$id_nama = $_REQUEST['id_nama'];
$table = $_REQUEST['table'];
$sql = "delete from ".$table." where ".$id_nama."='".$id_nilai."'";
$sql_exe = mysql_query($sql);
if($sql_exe){
	$status = 1;
	}
echo $status;	
?>

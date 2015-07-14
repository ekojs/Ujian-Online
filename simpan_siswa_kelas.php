<?php
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
include_once "include/fungsi.php";
$status = 0;
$data = $_REQUEST['data'];
$id_kelas = $_REQUEST['id_kelas'];
$tabel = $_REQUEST['tbl'];
$str_nilai = '';
$jml_data = count($data) - 1;
for($i = 0; $i <= $jml_data ; $i++){
	if($i < $jml_data){
		$str_nilai .='("'.$id_kelas.'","'.$data[$i].'"),';	
		}
	else {
		$str_nilai .='("'.$id_kelas.'","'.$data[$i].'")';	
		}	
}
$sql = "insert into ".$tabel." (id_kelas,nis) values ".$str_nilai;
$sql_exe = mysql_query($sql);
if($sql_exe){
	$status = 1;
	}
echo $status;	
?>

<?php
/*---------------------------------------------------------------------
 hapus data pada tabel berdasarkan primary key 
 ---------------------------------------------------------------------*/ 
include_once "include/koneksi.php";
include_once "include/fungsi.php"; 
$status = 0;
$data = $_REQUEST['data'];
$tabel = $_REQUEST['table'];
for($i = 0; $i < count($data); $i++){
	$data_ar=$data[$i];
	foreach($data_ar as $id => $nil){
		if($id == 'value'){
		$nilai[]=mysql_escape_string($data_ar[$id]);
		}
		else 
		$nama[]=$data_ar[$id];
	}
}
$sql = "update ".$tabel." set ".buatStringUpdateId($nama,$nilai);
$sql_exe = mysql_query($sql);
if($sql_exe){
	$status = 1;
	}
echo $status;	
?>

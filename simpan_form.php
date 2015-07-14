<?php
//error_reporting (E_ALL ^ E_NOTICE);
include_once "include/koneksi.php";
include_once "include/fungsi.php";
$status = 0;
$data = $_REQUEST['data'];
$tabel = $_REQUEST['tbl'];
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
$str_nilai = buatStringNilai($nilai);
$str_kolom = buatStringKolom($nama);
$sql = "insert into ".$tabel." (".$str_kolom.") values (".$str_nilai.")";
$sql_exe = mysql_query($sql);
if($sql_exe){
	$status = 1;
	}
echo $status;	
?>

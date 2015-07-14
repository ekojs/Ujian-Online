<?php
include_once "include/koneksi.php";
$data = $_REQUEST['data'];
$id_soal = $data['0'];
$id_ujian = $data['1'];
$pertanyaan = $data['2'];
$pil_jawaban = $data['3'];
$status = 0;
// simpan ke tabel soal
$sql_soal = "insert into soal values ('".$id_soal."','".$id_ujian."','".mysql_real_escape_string($pertanyaan)."')";
$sql_pil = "insert into pil_jawaban (id_soal,jawaban,status) values ";
$data_pil = "";
foreach($pil_jawaban as $pilihan){
	$data_pil .= "('".$id_soal."','".mysql_escape_string($pilihan['0'])."','".$pilihan['1']."'),";
	}
$data_pil = substr($data_pil,0,strlen($data_pil) - 1);
$sql_pil .= $data_pil;
$soal_exe = mysql_query($sql_soal);
if($soal_exe){
$pilihan_exe = mysql_query($sql_pil);
$status = 1;
}
echo $status;
?>

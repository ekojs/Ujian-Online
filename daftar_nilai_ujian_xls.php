<?php
include_once "include/koneksi.php";
$xlsfile = "Hasil_ujian_".date("d-m-Y").".xls";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$xlsfile");				
$id_mp = $_REQUEST['id_mp'];
$id_kelas = $_REQUEST['id_kelas'];
$nama_mp = mysql_result(mysql_query("select nama_mp from mapel where id_mp='".$id_mp."'"),0);
?>
<div style="width:80%;margin:0 auto" class="daftar_pelajaran">
<fieldset>
<legend>Daftar Nilai Ujian Mata Pelajaran <?php echo ucwords($nama_mp) ?></legend>
<?php
echo "<table class='listing' cellpadding='0' cellspacing='0'>";
//ambil data ujian pada id_mp ini sebagai header
echo "<tr>";
echo "<th>No</th><th>NIS</th><th>Nama</th>";
$sql_head = "select id_ujian,nama_ujian from ujian where id_mp='".$id_mp."' and id_kelas='".$id_kelas."'";
$sql_head_exe = mysql_query($sql_head);
$head_id_ujian = array();
while($head = mysql_fetch_assoc($sql_head_exe)){
	array_push($head_id_ujian,$head['id_ujian']);
	echo "<th>".$head['nama_ujian']."</th>";
	}
echo "<th>Rerata</th>";	
echo "</tr>";	
// ambil semua data siswa peserta ujian
$sql_siswa = "select nis,nama from siswa where nis in ( select nis from detail_kelas where id_kelas = '".$id_kelas."') ";
$sql_siswa_exe = mysql_query($sql_siswa);
// simpan aja di array dulu biar gampang
$data_siswa = array();
while($data = mysql_fetch_assoc($sql_siswa_exe)){
	$data_siswa[$data['nis']]['nama'] = $data['nama']; 
	}
$sql_nilai = "select id_user,nilai.id_ujian,ifnull(nilai,\"--\") as nilai from nilai right join ujian on ujian.id_ujian=nilai.id_ujian and nilai.id_ujian in (select id_ujian from ujian where id_mp='".$id_mp."') order by nilai.id_ujian,id_user";		
$sql_nilai_exe = mysql_query($sql_nilai);
while($data = mysql_fetch_assoc($sql_nilai_exe)){
	$data_siswa[$data['id_user']]['nilai'][$data['id_ujian']] = $data['nilai'];
	}
// tampilkan dalam tabel
$no = 1;
foreach($data_siswa as $id_siswa => $data_tampil){
	echo "<tr>";
	echo "<td>".$no++."</td>";
	echo "<td>".$id_siswa."</td>";
	echo "<td>".$data_tampil['nama']."</td>";
	$temp_arr = array();
	for($i = 0;$i < count($head_id_ujian); $i++){
		if(isset($data_tampil['nilai'][$head_id_ujian[$i]])){
		$nilainya = $data_tampil['nilai'][$head_id_ujian[$i]];
		}
		else $nilainya="---";
		echo "<td>".round($nilainya)."</td>";
		array_push($temp_arr,$nilainya);
		}
	echo "<td>".round(array_sum($temp_arr)/count($temp_arr))."</td>";		
	echo "</tr>";
	}
echo "</table>";
?>

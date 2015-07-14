<?php
include_once "include/cek_session.php"; 
include_once "include/koneksi.php"; 
$id_ujian = $_REQUEST['id_ujian'];
$sql_ujian = "select * from v_ujian_mapel where id_ujian='".$id_ujian."'";
$sql_ujian_exe = mysql_query($sql_ujian);
$data_ujian = mysql_fetch_assoc($sql_ujian_exe);
$nilai_exe = mysql_query("select nilai,detail_jawaban from nilai where id_user='".$_SESSION['nis_kj']."' and id_ujian='".$id_ujian."'");
$data_nilai = mysql_fetch_assoc($nilai_exe);
$jawaban_siswa_terpilih = explode(",",$data_nilai["detail_jawaban"]);
?>
<!-- awal div header -->
			<div class="block-content collapse in">
			<div class="span12">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
					<tr>
						<td width="150">Nama</td>
						<td width="600">: <?php echo $_SESSION['nama_kj']; ?></td>
						<td width="150">Kelas</td>
						<td>: <?php echo $nama_kelas ?></td>
					</tr>
					<tr>
						<td>Mata Pelajaran</td>
						<td>: <?php echo ucwords($data_ujian['nama_mp'])." ( ".ucwords($data_ujian['nama_ujian']).")" ?></td>
						<td>Nilai</td>
						<td>: <?php echo $data_nilai['nilai'] ?></td>
					</tr>
				</table>
			</div>
			</div>

	<!-- awal div tempat_soal -->
	<div id="tempat_soal">
<?php
// ambil pilihan jawaban dari database dan simpan de dalam array
$sql_pil = "select * from pil_jawaban where id_soal in (select id_soal from soal where id_ujian='".$id_ujian."') order by rand()";
$sql_pil_exe = mysql_query($sql_pil);
if(mysql_num_rows($sql_pil_exe) > 0){	
$data_pil_arr = array();
while($data = mysql_fetch_assoc($sql_pil_exe)){
	if(isset($data_pil_arr[$data['id_soal']])){
		$pil_jawabannya = array("id_jawaban" => $data['id_jawaban'],"status" => $data['status'],"jawaban" => $data['jawaban']);
		array_push($data_pil_arr[$data['id_soal']],$pil_jawabannya);
		}
	else {
		$data_pil_arr[$data['id_soal']] = array();
		$pil_jawabannya = array("id_jawaban" => $data['id_jawaban'],"status" => $data['status'],"jawaban" => $data['jawaban']);
		array_push($data_pil_arr[$data['id_soal']],$pil_jawabannya);
		}	
	}
// tampilkan soal ujian
$sql_soal = "select * from soal where id_ujian='".$id_ujian."' order by rand()";
$sql_soal_exe = mysql_query($sql_soal);
$no = 0;
while($soalnya = mysql_fetch_assoc($sql_soal_exe)){
	$no++;
	echo '<div class="block-content collapse in">
			<div class="span12">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
					<tr class="success">
						<td width="20">'.$no.'.</td>
						<td>'.$soalnya["isi_soal"].'</td>
					</tr>';
			//	$sql_pil = "select * from pil_jawaban where id_soal='".$soalnya['id_soal']."' order by rand()";
			//	$sql_pil_exe = mysql_query($sql_pil);
			//	while($data_pil = mysql_fetch_assoc($sql_pil_exe)){
			//		echo '<div class="pilihan_jawaban"><input type="radio" name="'.$data_pil['id_soal'].'" value="'.$data_pil['status'].'" onclick="koreksi(this)"/><div>'.$data_pil['jawaban'].'</div></div>';
			//		}
			foreach($data_pil_arr[$soalnya["id_soal"]] as $data_pil) {
				if(in_array($data_pil["id_jawaban"],$jawaban_siswa_terpilih)){
					$checked_radio = "checked";
					$class_div = "radio_terpilih";
					}
				else {
					$checked_radio = "";
					$class_div = "";
					}	
				echo '<tr>
						<td></td>
						<td class="pilihan_jawaban '.$class_div.'"><input alt="'.$data_pil["id_jawaban"].'" type="radio" name="'.$soalnya["id_soal"].'" value="'.$data_pil['status'].'" '.$checked_radio.' /> '.$data_pil['jawaban'].'</td>
					</tr>';
				}
	echo '</table></div></div></div></hr>';
	}
}
else {
	echo "soal masih belum ada !!!!!!!!!";
	}	
?>		
<div class="block-content collapse in">
	<div class="btn btn-success" onclick="kembali_daftar_ujian()"><i class="icon-white icon-circle-arrow-left"></i> Kembali</div>
</div>
</div><!-- akhir div tempat_soal -->
<script >
function kembali_daftar_ujian(){
	var id_mp = "<?php echo $data_ujian["id_mp"] ?>";
	$("#content").html(info_loading).load("daftar_ujian_siswa.php?id_mp="+id_mp);
	}		
</script>
<style>
.pilihan_jawaban > div{
	padding-left:5px;
	margin-left:25px;
	}
.radio_terpilih{
	background:#F4F4BA;
	}	
</style>

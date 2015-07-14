<?php
include_once "include/cek_session.php";
include_once "include/koneksi.php";
$id_kelas = $_REQUEST["id_kelas"];
?>
<div class="daftar_pelajaran">
<fieldset>
<legend>Pilih Mata Pelajaran</legend>
<?php
// ambil data mata pelajaran dari database
$mp_exe = mysql_query("select * from mapel");
$jml_mp = mysql_num_rows($mp_exe);
if($jml_mp > 0){
?>
	<ul>
		<?php
		while($data = mysql_fetch_assoc($mp_exe)){
			$jml_ujian = mysql_result(mysql_query("select count(*) from ujian where id_mp='".$data['id_mp']."' and id_kelas='".$id_kelas."'"),0);
			echo "<div onclick=\"lihat_nilai_ujian('".$data['id_mp']."')\"><span class='jml_ujian'>".$jml_ujian."</span><li>".$data['nama_mp']."</li>";
			echo "<div style='margin:10px'><span class='tombol edit'>Lihat Nilai</span></div>";
			echo "</div>";
			}
			
		?>
	</ul>
<?php	
	}
else {
	echo "Mata Pelajaran Belum Dibuat";
	}	
?>

</fieldset>
</div>
<div class="kembali" onclick="kembali_lagi()">Kembali</div>
<script>	
function lihat_nilai_ujian(id_mp){
	// load content dengan data dari daftar_ujian.php
	$("#content").html(info_loading).load("daftar_nilai_ujian.php?id_mp="+id_mp+"&id_kelas=<?php echo $id_kelas ?>");
}
function kembali_lagi(){
	$("#content").html(info_loading).load("daftar_nilai_kelas.php?id_kelas=<?php echo $id_kelas ?>");
	}
</script>
<style>
.daftar_pelajaran{
	width:80%;
	margin: 0 auto;
	}
.daftar_pelajaran>fieldset>ul>div{
	float:left;
	width:150px;
	min-height:120px;
	padding:6px;
	border-radius:5px;
	margin:10px;
	border:2px solid #000000;
//	background:#E5E5E5;
	color:#000000;
	}
.daftar_pelajaran div:hover{
	background:#FFFFFF;
	color:#000000;
	cursor:pointer;
	}
.jml_ujian{
	padding:3px;
	border-radius:4px;
	border:1px solid #105610;
	background:#479F47;
	color:#FFFFFF;
	font-weight:bolder;
	font-size:0.8 em;
	position:relative;
	float:right;
	margin-right:-6px;
	margin-top:-7px;
	z-index:20;
	}		
.daftar_pelajaran ul,.daftar_pelajaran li{
//	float:left;
	list-style:none;
//	text-align:center;
	}
.daftar_pelajaran li{
	position:relative;
	margin:0 auto;
	font-weight:bolder;
	border-bottom:2px solid #000000;
//	margin-top:30%;
	}
			
</style>

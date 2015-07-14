<?php
include_once "include/cek_session.php";
include_once "include/koneksi.php";
?>
<div class="row-fluid">
<div class="block">
     <div class="navbar navbar-inner block-header">
          <div class="muted pull-left">Pilih Mata Pelajaran</div>
     </div>
     <div class="block-content collapse in">
<?php
// ambil data mata pelajaran dari database
$mp_exe = mysql_query("select mapel.id_mp as id_mp,nama_mp,mengajar.id_kelas as id_kelas,nama_kelas from mapel,mengajar,kelas where mapel.id_mp = mengajar.id_mp and kelas.id_kelas=mengajar.id_kelas and id_guru='".$_SESSION['nis_kj']."'");
$jml_mp = mysql_num_rows($mp_exe);
if($jml_mp > 0){
?>
		<?php
		while($data = mysql_fetch_assoc($mp_exe)){
			$jml_ujian = mysql_result(mysql_query("select count(*) from ujian where id_mp='".$data['id_mp']."' and id_kelas='".$data['id_kelas']."'"),0);
			echo "<div class='navbar navbar-inner block-header span3'><div class='muted pull-left'><strong>".$data['nama_mp']."";
			echo " ".$data['nama_kelas']."   <span class='badge badge-success'>  ".$jml_ujian."</span></strong></div>";
			echo "<br><br/><div onclick=\"lihat_ujian('".$data['id_mp']."','".$data['id_kelas']."')\"><button class='btn btn-success'><i class='icon-white icon-plus'></i> Tambah Ujian</button></div>";
			echo "<br/></div>";
			}
			
		?>
<?php	
	}
else {
	echo "Mata Pelajaran Belum Dibuat";
	}	
?>

</fieldset>
</div>
<script>	
function lihat_ujian(id_mp,id_kelas){
	// load content dengan data dari daftar_ujian.php
	$("#content").html(info_loading).load("daftar_ujian_guru.php?id_mp="+id_mp+"&id_kelas="+id_kelas);
	$("body").data("back_url","daftar_mp_ajar.php");
	}	
</script>

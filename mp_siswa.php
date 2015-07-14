<?php
include_once "include/cek_session.php";  
include_once "include/koneksi.php";
$id_kelas = $_SESSION['id_kelas'];
?>
<div class="row-fluid">
<?php
// ambil data mata pelajaran dari database
$mp_exe = mysql_query("select * from mapel");
$jml_mp = mysql_num_rows($mp_exe);
if($jml_mp > 0){
?>

<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Pilih Mata Pelajaran</div>
			</div>
			<div class="block-content collapse in">
			<div class="span12">                                    
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Mata Pelajaran</th>
							<th>Jumlah Ujian</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php
		while($data = mysql_fetch_assoc($mp_exe)){
			$jml_ujian = mysql_result(mysql_query("select count(*) from ujian where id_mp='".$data['id_mp']."' and id_kelas='".$id_kelas."'"),0);
			echo"<td>".$data['nama_mp']."</td>
							<td>".$jml_ujian."</td>
							<td><div onclick=\"lihat_ujian_siswa('".$data['id_mp']."')\" class='btn btn-success' ><i class='icon-pencil icon-white'></i> Daftar ujian</div></td>
						</tr>
					</tbody>";	
			}
			
		?>
<?php	
	}
else {
	echo "Mata Pelajaran Belum Dibuat";
	}	
?>

</div>
<script>	
function lihat_ujian_siswa(id_mp){
	// load content dengan data dari daftar_ujian.php
	$("#content").html(info_loading).load("daftar_ujian_siswa.php?id_mp="+id_mp);
	}
</script>

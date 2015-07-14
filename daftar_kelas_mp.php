<?php
/*--------------------------------------------------------
 * Tampilkan link untuk melihat nilai mata pelajaran tertentu pada kelas tertentu
 *--------------------------------------------------------*/ 
include_once "include/cek_session.php";
include_once "include/koneksi.php"; 
?>
<div class="container-fluid">

	<div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Daftar Nilai Mata Pelajaran</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">	                                    
  									<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
										<?php
	$sql_mp="select * from mapel";
	$sql_exe_mp = mysql_query($sql_mp);
	$mp_array = array();
	while($data = mysql_fetch_assoc($sql_exe_mp)){
		$mp_array[$data['id_mp']] = $data['nama_mp'];
		}
	$sql_kelas="select * from kelas";
	$sql_exe_kelas = mysql_query($sql_kelas);
	$kelas_array = array();
	while($data = mysql_fetch_assoc($sql_exe_kelas)){
		$kelas_array[$data['id_kelas']] = $data['nama_kelas'];
		}
//	echo $sql_tampil;
	if(count($mp_array) > 0){
	echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered'>";	
	// buat headernya kawan
	echo "<thead>";
	echo "<tr>";
	echo "<th>No</th>";
	echo "<th>Mata Pelajaran</th>";	
	echo "<th>Aksi</th>";	
	echo "</tr>";
	echo "</thead>";
	echo "<tbody id='daftar_guru'>";
	$no = 1;
	foreach($mp_array as $id_mp => $nama_mp){
		echo "<tr class='odd gradeX'>";
		echo "<td>".$no++."</td>";
		echo "<td>".$nama_mp."</td>";
		echo "<td>"; 
		foreach($kelas_array as $id_kelas => $nama_kelas){
			echo "<div class='btn-group'>
					<span onclick=\"daftar_nilai_mp('".$id_mp."','".$id_kelas."')\" style='margin:3px'><button class='btn btn-success'><i class='icon-eye-open icon-white'></i> ".$nama_kelas."</button></span>
                  </div>";
			}
		echo "</td>";	
		echo"</tr>";
		}		
	echo "</tbody>";
	echo "</table>";

		}
	else {
		echo "Data masih kosong, diisi dulu ya ........";
		}	 
	?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
</div>
<script >
function daftar_nilai_mp(id_mp,id_kelas){
	// load content dengan data darin daftar_ujian.php
	$("#content").html(info_loading).load("daftar_nilai_ujian.php?id_mp="+id_mp+"&id_kelas="+id_kelas);
	$("body").data("back_url","daftar_kelas_mp.php");
	}		
</script>



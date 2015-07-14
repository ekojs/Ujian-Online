<?php
/*--------------------------------------------------------
 * Buat ujian untuk mata pelajaran tertentu
 *--------------------------------------------------------*/ 
include_once "include/cek_session.php";  
include_once "include/koneksi.php"; 
$id_mp = $_REQUEST['id_mp'];
$id_kelas = $_SESSION['id_kelas'];
$nama_mp = mysql_result(mysql_query("select nama_mp from mapel where id_mp='".$id_mp."'"),0);
?>
<div class="row-fluid">
<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Daftar Ujian Pada Mata Pelajaran <?php echo $nama_mp ?></div>
			</div>
<div class="block-content collapse in">
			<div class="span12">                                    
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Ujian</th>
							<th>Tanggal</th>
							<th>Waktu</th>
							<th>Keterangan</th>
							<th>Aksi</th>
							<th>Nilai</th>
						</tr>
					</thead>
					
<?php
// cek ujian yang sudah dilaksanakan
$sql_nilai = "select id_ujian,nilai from nilai where id_user='".$_SESSION['nis_kj']."'";
$sql_nilai_exe = mysql_query($sql_nilai);
if(mysql_num_rows($sql_nilai_exe) > 0){
	$nilai = array();
	while($d_nilai = mysql_fetch_assoc($sql_nilai_exe)){
		$nilai[$d_nilai['id_ujian']] = $d_nilai['nilai'];
		}
	}
// tampilkan seluruh ujian pada mata pelajaran ini
$sql = "select * from ujian where id_mp ='".$id_mp."' and id_kelas='".$id_kelas."'";
$sql_exe = mysql_query($sql);
$no = 1;
$data_grafik = array();
$nilai_grafik = array();
while($data = mysql_fetch_assoc($sql_exe)){
	echo "<tbody>
			<tr>";
	echo "<td>".$no++."</td>";
	echo "<td>".$data['nama_ujian']."</td>";
	echo "<td>".$data['tanggal']."</td>";
	echo "<td>".$data['waktu']." Menit</td>";
	echo "<td>".$data['keterangan']."</td>";
	array_push($data_grafik,$data['nama_ujian']);
// jika sudah dikerjakan
	if(isset($nilai[$data['id_ujian']])){
	echo "<td><span class='btn btn-success' onclick='view_jawaban(\"".$data['id_ujian']."\")'><i class='icon-white icon-pencil'></i> Jawaban</span></td>";
	echo "<td>".$nilai[$data['id_ujian']]."</td>";
	array_push($nilai_grafik,$nilai[$data['id_ujian']]);	
		}
	else {
	echo "<td><span class='btn btn-success' onclick='kerjakan_ujian(\"".$data['id_ujian']."\")'><i class='icon-white icon-pencil'></i> Kerjakan</span></td>";
	echo "<td>Nilainya</td>";
	array_push($nilai_grafik,0);	
	}	
	
	echo "</tbody>";
	}

?>


<!-- tempat grafik -->
	<div id="container" style="width:100%">
</table>
</div>
<div class="btn btn-success" onclick="kembali_daftar_mp()"><i class="icon-white icon-circle-arrow-left"></i> Kembali</div>
</div>		
</div>

<script src="js/highcharts.js" type="text/javascript"></script>
<script type="text/javascript">
	var chart1; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },   
         title: {
            text: 'Grafik Nilai Ujian '
         },
         xAxis: {
            categories: ['Nama Ujian']
         },
         yAxis: {
            title: {
               text: 'Nilai'
            }
         },
              series:             
            [
                      <?php
                      for ($i = 0; $i < count($data_grafik); $i++)
					  {
					  
					  ?>
					  {	  
				      name: '<?php echo $data_grafik[$i]; ?>',
                      data: [<?php echo $nilai_grafik[$i]; ?>]
                  },
                  <?php } ?>
			]
      });
   });	

function kembali_daftar_mp(){
	$("#content").html(info_loading).load("mp_siswa.php");
	}		
function kerjakan_ujian(id_ujian){
	$("#content").html(info_loading).load("kerjakan_ujian.php?id_ujian="+id_ujian);
	}
function view_jawaban(id_ujian){
	$("#content").html(info_loading).load("view_jawaban.php?id_ujian="+id_ujian);
	}
	
</script>
<style>
.daftar_ujian{
	border:1px solid gray;
	margin:2px;
	overflow:auto;
	}	
.daftar_ujian div{
	float:left;
	margin:3px;
	padding:4px;
	}
.daftar_ujian div.no{
	width:2%;
	}	
.daftar_ujian div.nama_ujian{
	width:15%;
	}
.daftar_ujian div.tanggal{
	width:15%;
	}
.daftar_ujian div.waktu{
	width:14%;
	}
.daftar_ujian div.ket{
	width:20%;
	}			
.daftar_ujian div.aksi{
	width:10%;
	}	
</style>

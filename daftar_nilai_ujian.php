<?php
// current time
$mtime = microtime();
// split seconds and microseconds
$mtime = explode(" ",$mtime);
// create a single value for statr time
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
include_once "include/koneksi.php";
$id_mp = $_REQUEST['id_mp'];
$id_kelas = $_REQUEST["id_kelas"];
$nama_mp = mysql_result(mysql_query("select nama_mp from mapel where id_mp='".$id_mp."'"),0);
?>
<div class="container-fluid">
	<div class="row-fluid">
    <!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Daftar Nilai Ujian Mata Pelajaran <?php echo ucwords($nama_mp) ?></div>
            </div>
            <div class="block-content collapse in">
				<div class="span12">	
					<div style="margin-bottom:10px"><span onclick="download_ini()" class="btn btn-primary"><i class="icon-white icon-download"></i> Download as xls</span></div>
<?php
echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
//ambil data ujian pada id_mp ini sebagai header
echo "<thead>"; 
echo "<tr>";
echo "<th width='10'>No</th><th>NIS</th><th>Nama</th>";
$sql_head = "select id_ujian,nama_ujian from ujian where id_mp='".$id_mp."' and id_kelas='".$id_kelas."'";
$sql_head_exe = mysql_query($sql_head);
$head_id_ujian = array();
while($head = mysql_fetch_assoc($sql_head_exe)){
	array_push($head_id_ujian,$head['id_ujian']);
	echo "<th>".$head['nama_ujian']."</th>";
	}
echo "<th>Rerata</th><th width='70'>Aksi</th>";	
echo "</tr>";
echo "</thead>";	
if(count($head_id_ujian) > 0){
// ambil semua data siswa peserta ujian
$sql_siswa = "select siswa.nis as nis,nama from siswa,detail_kelas where siswa.nis = detail_kelas.nis and id_kelas='".$id_kelas."'";
$sql_siswa_exe = mysql_query($sql_siswa);
// simpan aja di array dulu biar gampang
$data_siswa = array();
$data_grafik = $nilai_grafik = array(); // untuk data menggambar grafik
while($data = mysql_fetch_assoc($sql_siswa_exe)){
	$data_siswa[$data['nis']]['nama'] = $data['nama']; 
	}
$sql_nilai = "select id_user,nilai.id_ujian,ifnull(nilai,\"--\") as nilai from nilai natural join ujian where nilai.id_ujian in (select id_ujian from ujian where id_mp='".$id_mp."' and id_kelas='".$id_kelas."') order by nilai.id_ujian,id_user";		
$sql_nilai_exe = mysql_query($sql_nilai);
while($data = mysql_fetch_assoc($sql_nilai_exe)){
	$data_siswa[$data['id_user']]['nilai'][$data['id_ujian']] = $data['nilai'];
	}
// tampilkan dalam tabel
$no = 1;
echo "<tbody>";
foreach($data_siswa as $id_siswa => $data_tampil){
	echo "<tr>";
	echo "<td>".$no++."</td>";
	echo "<td class='nis'>".$id_siswa."</td>";
	echo "<td>".$data_tampil['nama']."</td>";
	array_push($data_grafik,$data_tampil['nama']);
	$temp_arr = array();
	for($i = 0;$i < count($head_id_ujian); $i++){
		if(isset($data_tampil['nilai'][$head_id_ujian[$i]])){
		$nilainya = $data_tampil['nilai'][$head_id_ujian[$i]];
		}
		else $nilainya="--";
		array_push($temp_arr,$nilainya);
		if(is_numeric($nilainya)){
			$nilainya = number_format($nilainya,1);
			}
		echo "<td class='nilai' title='".$head_id_ujian[$i]."'>".$nilainya."</td>";
		
		}
	$rerata = number_format(array_sum($temp_arr)/count($temp_arr),3);	
	echo "<td>".$rerata."</td>";		
	echo "<td><span class='btn btn-success' onclick='edit_nilai(this);this.onclick=null'><i class='icon-pencil icon-white'></i> Nilai</span></td>";
	echo "</tr>";
	array_push($nilai_grafik,$rerata);
	}
echo "</tbody>";		
/*
$no = 1;
while($data = mysql_fetch_assoc($sql_siswa_exe)){
	echo "<tr>";
	echo "<td>".$no++."</td>";
	echo "<td>".$data['nis']."</td>";
	echo "<td>".$data['nama']."</td>";
	$sql_nilai = "select ifnull(nilai,\"belum dikerjakan\") as nilai from nilai right join ujian";
	$sql_nilai .=" on ujian.id_ujian = nilai.id_ujian and ujian.id_ujian in (select id_ujian from v_ujian_mapel where id_mp='".$id_mp."')";
	$sql_nilai .=" and id_user='".$data['nis']."' group by ujian.id_ujian order by ujian.id_ujian";	
	$sql_nilai_exe = mysql_query($sql_nilai);
	$temp_arr = array();
	while($d_nilai = mysql_fetch_assoc($sql_nilai_exe)){
		echo "<td>".$d_nilai['nilai']."</td>";
		array_push($temp_arr,$d_nilai['nilai']);
		}
	echo "<td>".number_format(array_sum($temp_arr)/count($temp_arr),3)."</td>";	
	echo "</tr>"; 
	}
	*/ 
}
else {
	echo "<td colspan='5'>Belum ada ujian yang dibuat</td>";
	}
echo "</table>";
echo "<div style='color:#1717BF;font-size:90%;font-weight:bolder;font-style:italic'>--- &nbsp;&nbsp;berarti belum dikerjakan</div>";
// current time
$mtime = microtime();
// split seconds and microseconds
$mtime = explode(" ",$mtime);
// create a single value for statr time
$mtime = $mtime[1] + $mtime[0];
$tend = $mtime;
// hitung waktu eksekusi
$totaltime = ($tend - $tstart);
// Output the result
printf ("This page was generated in %f seconds.", $totaltime);
?>
</fieldset>
<!-- tempat grafik -->
<div id="container" style="width:100%"></div>		
</div>
<div class="btn btn-success" onclick="kembali_lagi()"><i class="icon-white icon-circle-arrow-left"></i> Kembali</div>
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
            categories: ['Nama Siswa']
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
function download_ini(){
	var id_mp = "<?php echo $id_mp ?>";
	var id_kelas = "<?php echo $id_kelas ?>";
	window.open("daftar_nilai_ujian_xls.php?id_mp="+id_mp+"&id_kelas="+id_kelas);
	}
function edit_nilai(elm){
	var tmb_reset = "<span style='margin-left:5px' class='btn btn-danger' onclick='reset_nilai(this)'><i class='icon-repeat icon-white'></i> Reset</span>";
	$(elm).parent().parent().find("td.nilai").each(function(){
		if($(this).text() != "--"){
		$(tmb_reset).appendTo(this);
		}
		})
	}
function reset_nilai(elm){
	var nis = $(elm).parent().parent().find("td.nis").eq(0).text();
	var id_ujian = $(elm).parent().attr("title");
	// hapus nilai siswa pada ujian tersebut
	var url = "hapus_nilai_ujian.php";
	$.post(url,{nis:nis,id_ujian:id_ujian},function(hasil){
		if(hasil == 1){
			$(elm).parent().css({"background":"#BBEEBB"}).text("---");
			}
		else {
			alert("gagal dihapus .......");
			}	
		})
	}		
</script>
<style>
.hapus:hover{
	cursor:pointer;
	}
</style>

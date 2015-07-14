<?php
include_once "include/cek_session.php";
include_once "include/koneksi.php";
$id_kelas = $_REQUEST['id_kelas'];
?>
<div style="width:80%;margin:0 auto">	
<fieldset style="margin:0 auto">
<legend>Daftar Siswa Belum Terdaftar di Kelas </legend>
	<?php
	$perhal = 5; // jumlah data yang ditampilkan dalam tabel
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
	$index_hal = ($hal - 1 ) * $perhal ;
	$sql_all = "select * from siswa where nis not in (select nis from detail_kelas)";
	$sql_exe_all = mysql_query($sql_all);
	$jml_all = mysql_num_rows($sql_exe_all);
	$jml_hal = round($jml_all / $perhal); // hitung jumlah seluruh halaman
	$sql_tampil="select * from siswa where nis not in (select nis from detail_kelas) limit ".$index_hal.",".$perhal;
	$sql_exe_tampil = mysql_query($sql_tampil);
//	echo $sql_tampil;
	if(mysql_num_rows($sql_exe_tampil) > 0){
	echo "<table class='listing' cellpadding='0' cellspacing='0'>";	
	// buat headernya kawan
	echo "<thead>";
	echo "<tr>";
	echo "<th>No</th>";
	echo "<th><input type='checkbox' onclick='check_all(this)'/></th>";	
	$jum_kolom = mysql_num_fields($sql_exe_tampil);
	for($i = 0; $i < $jum_kolom; $i++){
		echo "<th>".mysql_field_name($sql_exe_tampil,$i)."</th>";
		}
	echo "</tr>";
	echo "</thead>";
	echo "<tbody id='daftar_siswa'>";
	$no = $index_hal + 1;
	while($data_baris = mysql_fetch_assoc($sql_exe_tampil)){
		echo "<tr>";
		echo "<td>".$no++."</td>";
		echo "<td><input name='nis[]' type='checkbox' value='".$data_baris['nis']."' /></td>";	
		foreach($data_baris as $data){
			echo "<td>".$data."</td>";
			}
		echo "</tr>";
		}
	echo "</tbody>";
	echo "</table>";
	echo "<div style='margin:10px;margin-left:0px'><span class='tombol tambah' onclick='masukkan_siswa_kelas()'>Masukkan ke Kelas</span></div>";
		// tampilkan pagingnya
	echo "<div class='paging'>"; 	
	echo "<ul>";
		for ($i = 1; $i <= $jml_hal ; $i++)
			{
				if($i == $hal){
					echo "<li onclick='load_daftar_siswa_tanpa_kelas(this)' style='background-color:green'>".$i."</li>";
					}
				else {	
					echo "<li onclick='load_daftar_siswa_tanpa_kelas(this)'>".$i."</li>";
					}
			}
	echo "</ul>";
	echo "</div>";	
		}
	else {
		echo "Data masih kosong, diisi dulu ya ........";
		}	 
	?>
</fieldset>
</div>
<div class="kembali" onclick="kembali_lagi()">Kembali</div>
<script>
function load_daftar_siswa_tanpa_kelas(elm){
	var info_loading = "<div style='font-size:110%;font-style:italic;font-weight:bolder;width:150px;margin:0 auto;' class='tombol loading'>Sedang proses .............</div>";	
	var hal = $(elm).text();
	var url = "daftar_siswa_tanpa_kelas.php?hal="+hal;
	$("#content").html(info_loading).load(url);
	}	
function check_all(elm){
	var checked = $(elm).attr('checked');
	$('input[name^=nis]').attr('checked',checked);
	}	
function masukkan_siswa_kelas(){
	var url = "simpan_siswa_kelas.php";
	var tabel = "detail_kelas";
	var id_kelas ="<?php echo $id_kelas; ?>";
	var data = new Array();
	$('input[name^=nis]:checked').each(function(){
		 data.push($(this).val());
		});
	$.post(url,{data:data,tbl:tabel,id_kelas:id_kelas},function(result){
				if(result == 1){
					var url = "daftar_siswa_tanpa_kelas.php?hal=1";
					$("#content").html(info_loading).load(url);
					}
		});	
	}	
</script>	

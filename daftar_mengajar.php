<?php
/*--------------------------------------------------------
 * Setting guru pada mata pelajaran tertentu
 *--------------------------------------------------------*/ 
include_once "include/cek_session.php";  
include_once "include/koneksi.php"; 
$id_kelas = $_REQUEST['id_kelas'];
$nama_kelas = mysql_result(mysql_query("select nama_kelas from kelas where id_kelas='".$id_kelas."'"),0);
?>
<div class="row-fluid">
	<div class="block">
		<div class="navbar navbar-inner block-header">
			<div class="muted pull-left">Daftar Ujian Pengajar Mata Pelajaran Pada <?php echo $nama_kelas ?></div>
        </div>
        
		<div class="block-content collapse in">
			<div class="span12">                                    
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Pelajaran</th>
							<th>Pengajar</th>
						</tr>
					</thead>
<?php
// cek daftar mata pelajaran yang telah ditentukan guru pengajarnya
$sql_mengajar = "select id_mp,id_kelas,id_guru from mengajar where id_kelas='".$id_kelas."'";
$sql_mengajar_exe = mysql_query($sql_mengajar);
$data_ajar = array();
while($data = mysql_fetch_assoc($sql_mengajar_exe)){
	$data_ajar[$data['id_mp']] = $data['id_guru'];
	}
// buat daftar pengajar sebagai drop down
$sql_guru = "select * from guru";
$sql_guru_exe = mysql_query($sql_guru);
$data_guru = array();
while($data = mysql_fetch_assoc($sql_guru_exe)){
	//$select_dropdown .= "<option value='".$data['nis']."'>".$data['nama']."</option>";
	$data_guru[$data['nis']] = $data['nama'];
	}
$sql_mapel = "select id_mp,nama_mp from mapel";
$sql_mapel_exe = mysql_query($sql_mapel);
$no = 1;
while($data = mysql_fetch_assoc($sql_mapel_exe)){
	echo "<tbody>
			<tr>
				<td>".$no++."</td>
				<td>".$data['nama_mp']."</td>
				<td><input type='hidden' value='".$data['id_mp']."' />";
		$select_dropdown = "<select onchange='set_guru(this)'>";
		$select_dropdown .= "<option value=''>Pilih guru</option>";
		foreach($data_guru as $id_guru => $nama_guru){
			if($id_guru == $data_ajar[$data['id_mp']]){
				$selected = "selected";
				}
			else {
				$selected = "";
				}	
			$select_dropdown .= "<option ".$selected." value='".$id_guru."'>".$nama_guru."</option>";
			}
		$select_dropdown .= "</select>";	
	echo $select_dropdown."
			</td>
			</tr>
		  </tbody>";	
			}
			?>
		</table>
	   </div>
	</div>

	<div class="block-content collapse in">
		<button class="btn btn-success" onclick="kembali_lagi()"><i class="icon-circle-arrow-left icon-white"></i> Kembali</button>
	</div>
<script type="text/javascript">
function set_guru(elm){
	var id_mp = $(elm).prev().val();	
	if(id_mp != ''){
	var nama_mp = $(elm).parent().prev().text();
	var nama_guru = $(elm).find('option:selected').text();
	var jawab = confirm("Apakah anda akan menjadikan guru "+nama_guru+ "\n sebagai pengajar pelajaran "+nama_mp);
	if(jawab){
		var id_guru = $(elm).val();
		var url = "simpan_form.php";
		var tabel = "mengajar";
		var data = [{"name":"id_mp","value":id_mp},{"name":"id_kelas","value":<?php echo $id_kelas ?>},{"name":"id_guru","value":id_guru}];
		$.post(url,{data:data,tbl:tabel},function(hasil){
			if(hasil == 1){
				alert("data telah disimpan");
				}
			else {
				alert("data gagal disimpan");
				}	
		})
	}
  }	
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

<?php
/*--------------------------------------------------------
 * Buat ujian untuk mata pelajaran tertentu
 * fungsi bersihkan() dan kembali_semula() telah didefinisikan
 * pada file hal_guru.php dengan asumsi bahwa sebelum membuka
 * halaman ini pasti telah membuka terlebih dahulu halaman
 * hal_guru.php ( halaman awal )
 *--------------------------------------------------------*/ 
include_once "include/cek_session.php";
include_once "include/koneksi.php"; 
$id_kelas = $_REQUEST['id_kelas'];
$nama_kelas = mysql_result(mysql_query("select nama_kelas from kelas where id_kelas='".$id_kelas."'"),0);
?>
<div class="row-fluid">
<form id="f_ujian">
<span class="btn btn-success" id="simpan_siswa_kelas" onclick="tambah_siswa_kelas()"><i class="icon-white icon-plus"></i> Siswa</span>
<span id="pindah_kelas" style="display:none">
<span class="tombol simpan" onclick="pindah_kelas(this)">Siswa</span>
<span class="tombol batal" onclick="batal_update()">Batal</span>
</span>
</form>
<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Daftar Siswa Pada Kelas <?php echo $nama_kelas ?></div>
			</div>
			
			<div class="block-content collapse in">
			<div class="span12">                                    

								
	<div class='daftar_ujian'>
	<div class='NO'>No</div>
	<div class='nis'>NIS</div>
	<div class='nama'>Nama</div>
	<div class='alamat'>Alamat</div>
	<div style='width: 150px' class='hapus'>Hapus</div>
	<div class='aksi'>Pindahkan</div>
</div>	
<?php
// tampilkan seluruh ujian pada mata pelajaran ini
$sql = "select siswa.nis as nis,nama,alamat from siswa,detail_kelas,kelas where kelas.id_kelas ='".$id_kelas."' and siswa.nis=detail_kelas.nis and detail_kelas.id_kelas = kelas.id_kelas";
$sql_exe = mysql_query($sql);
$no = 1;
while($data = mysql_fetch_assoc($sql_exe)){
	echo "<div class='daftar_ujian'>";
	echo "<div class='no'>".$no++."</div>";
	echo "<div class='nis'>".$data['nis']."</div>";
	echo "<div class='nama'>".$data['nama']."</div>";
	echo "<div class='alamat'>".$data['alamat']."</div>";
	echo "<div style='width: 150px' class='hapus'><span class='btn btn-danger' onclick='hapus_siswa_kelas(this,\"".$data['nis']."\")'><i class='icon-white icon-trash'></i> Siswa</span></div>";	
	echo "<div class='aksi_pindah'></div></div>";
	}

?>
</div>
<div class="btn btn-success" onclick="kembali_lagi()"><i class="icon-white icon-circle-arrow-left"></i> Kembali</div>
<?php
		$sql_kelas = "select * from kelas";
		$sql_kelas_exe = mysql_query($sql_kelas);
		$data_option = "<select name='id_kelas' onchange='simpan_pindah_kelas(this)'>";
		while($data = mysql_fetch_assoc($sql_kelas_exe)){
			if($id_kelas == $data['id_kelas']){
				$selected = "selected";
				}
			else {
				$selected = "";
				}	
			$data_option .="<option ".$selected." value='".$data['id_kelas']."'>".$data['nama_kelas']."</option>";	
		}
		$data_option .="</select>";
	?>
<script type="text/javascript">
function tambah_siswa_kelas(){
	$("#content").html(info_loading).load("daftar_siswa_tanpa_kelas.php?id_kelas=<?php echo $id_kelas ?>");
	$("body").data("back_url","daftar_siswa_perkelas.php?id_kelas=<?php echo $id_kelas ?>");
	}
function hapus_siswa_kelas(elm,nis){
	var hapus = confirm("Anda akan menghapus siswa ini dari kelas ...<?php echo $nama_kelas ?>'");
	if(hapus){
	var url = "hapus_data.php";		
	$.post(url,{id_nilai:nis,id_nama:"nis",table:"detail_kelas"},function(hasil){
		if(hasil == 1){
			// hapus dibaris yang dihapus saja kawan
			$(elm).parent().parent().remove();
		//	$("#content").html("").load("daftar_ujian.php?id_kelas=<?php echo $id_kelas; ?>");
			}
		else {
			alert("gagal dihapus cek query anda .....");
			}	
		})
	}
}
function simpan_pindah_kelas(elm){
		var jawab = confirm("Anda akan memindahkan siswa ini ke kelas "+$(elm).find('option:selected').text()+" ?");
		if(jawab){	
			var url = "update_data.php";
			var tabel = "detail_kelas";
			var data = [{"name":"nis","value":$(elm).next().val()},{"name":"id_kelas","value":$(elm).val()}];
			$.post(url,{data:data,table:tabel},function(hasil){
				if(hasil == 1){
					$(elm).parent().parent().remove();
				}
				else{
				alert("gagal disimpan, mungkin data sudah ada \n atau koneksi bermasalah"+hasil);
				}	
			})
		}				
	}
$(function(){
	calendar.set("nama");
	$("body").data("back_url","daftar_kelas.php");
	// buat dropdown select dari nama kelas di database
	var data_option = "<?php echo $data_option ?>";
	$('div.aksi_pindah').each(function(){
		var nis = $(this).prevAll('div.nis').text();
		$("<label>Ke Kelas</label> "+data_option+"<input type='hidden' value='"+nis+"' />").appendTo($(this));
		})
})
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
.daftar_ujian div.nis{
	width:10%;
	}
.daftar_ujian div.nama{
	width:10%;
	}
.daftar_ujian div.alamat{
	width:15%;
	}
</style>

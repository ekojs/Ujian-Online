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
$id_mp = $_REQUEST['id_mp'];
$id_kelas = $_REQUEST['id_kelas'];
$nama_kelas = mysql_result(mysql_query("select nama_kelas from kelas where id_kelas='".$id_kelas."'"),0);
$nama_mp = mysql_result(mysql_query("select nama_mp from mapel where id_mp='".$id_mp."'"),0);
?>
<div class="row-fluid">
	 
<form id="f_ujian">
<div class="span12">
	<div class="span2">
		<input type="hidden" name="id_mp" id="id_mp" value="<?php echo $id_mp ?>" style="width: 200px" class="inputan input-block-level"/>	
		<input type="hidden" name="id_kelas" id="id_kelas" value="<?php echo $id_kelas ?>" style="width: 200px" class="inputan input-block-level"/>	
		<input type="text" name="nama_ujian" id="nama_ujian" value="Nama Ujian" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span2">
		<input type="text" name="tanggal" id="tanggal" value="Tanggal ujian" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span2">
		<input type="text" name="waktu" id="waktu" value="Waktu (dalam menit)" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span2">
		<input type="text" name="keterangan" id="keterangan" size="60" value="Keterangan" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span4">
		<span class="btn btn-success tombol tambah" id="simpan_ujian" onclick="simpan_ujian(this)"><i class="icon-white icon-plus"></i> Ujian</span>	
		<span id="update_ujian" style="display:none">
		<span class="btn btn-success tombol simpan" onclick="update_ujian(this)"><i class="icon-white icon-ok"></i> Simpan</span>
		<span class="btn btn-danger" onclick="batal_update()"><i class="icon-white icon-remove"></i> Batal</span>
		</span>
	</div>
</div>
</form>
</div>

<div class="block">
     <div class="navbar navbar-inner block-header">
          <div class="muted pull-left">Daftar Ujian Pada Mata Pelajaran <?php echo $nama_mp ?> Kelas <?php echo $nama_kelas ?></div>
     </div>
     <div class="block-content collapse in">
		 
	<div class='daftar_ujian'>
	<div class='no'>No</div>
	<div class='nama_ujian'>Nama Ujian</div>
	<div class='tanggal'>Tanggal</div>
	<div class='waktu'>Waktu</div>
	<div class='jml_soal'>Jumlah Soal</div>
	<div class='ket'>Keterangan</div>
	<div class='aksi'>Aksi</div>
</div>	
<?php
// tampilkan seluruh ujian pada mata pelajaran ini
$sql = "select * from ujian where id_mp ='".$id_mp."' and id_kelas='".$id_kelas."'";
$sql_exe = mysql_query($sql);
$no = 1;
while($data = mysql_fetch_assoc($sql_exe)){
	echo "<div class='daftar_ujian'>";
	echo "<div class='no'>".$no++."</div>";
	echo "<div class='nama_ujian'>".$data['nama_ujian']."</div>";
	echo "<div class='tanggal'>".$data['tanggal']."</div>";
	echo "<div class='waktu'>".$data['waktu']." Menit</div>";
	$jml_soal = mysql_result(mysql_query("select count(*) from soal where id_ujian='".$data['id_ujian']."'"),0);
	echo "<div class='jml_soal'>".$jml_soal."</div>";
	echo "<div class='ket'>".$data['keterangan']."</div>";
	echo "<div class='aksi'><span class='btn btn-success tombol edit' onclick='edit_ujian(this,\"".$data['id_ujian']."\")'><i class='icon-white icon-pencil'></i> Ujian</span>&nbsp;<span class='btn btn-primary tombol tambah' onclick='tambah_soal_ujian(\"".$data['id_ujian']."\")'>";
	echo "<i class='icon-white icon-plus'></i> Soal</span>&nbsp;<span class='btn btn-warning tombol edit' onclick='edit_soal_ujian(\"".$data['id_ujian']."\")'><i class='icon-white icon-pencil'></i> Soal</span>&nbsp;<span class='btn btn-danger tombol hapus' onclick='hapus_ujian(this,\"".$data['id_ujian']."\")'><i class='icon-white icon-trash'></i> Ujian</span></div>";
	echo "</div>";
	}

?>


<br/>
<div class="row-fluid">
	<div class="btn btn-success" onclick="kembali_lagi()"><i class="icon-white icon-circle-arrow-left"></i> Kembali</div>
</div>

<script type="text/javascript">
function tambah_soal_ujian(id_ujian){
	$("#content").html(info_loading).load("buat_soal.php?id_ujian="+id_ujian+"&id_kelas="+<?php echo $id_kelas ?>);
	$("body").data("back_url","daftar_ujian.php?id_mp=<?php echo $id_mp ?>&id_kelas=<?php echo $id_kelas ?>");
}	
function edit_soal_ujian(id_ujian){
	$("#content").html(info_loading).load("edit_soal.php?id_ujian="+id_ujian+"&id_kelas="+<?php echo $id_kelas ?>);
	$("body").data("back_url","daftar_ujian.php?id_mp=<?php echo $id_mp ?>&id_kelas=<?php echo $id_kelas ?>");
}		
function simpan_ujian(elm){
	var errornya = 0;
	$(".inputan").each(function(){
		if($(this).val() == ""){
			errornya++;
			$(this).focus();
			return false;
			}
		})	
	if(errornya == 0){
		//simpan ke database
		var data = $(elm).parent().serializeArray();
		var url = "simpan_form.php";
		var tabel = "ujian";
		$.post(url,{data:data,tbl:tabel},function(hasil){
			if(hasil == 1){
				// reload content dengan halaman ini, karena kita butuh id_ujian dari server
				$("#content").html(info_loading).load("daftar_ujian.php?id_mp=<?php echo $id_mp; ?>&id_kelas=<?php echo $id_kelas ?>");
				}
			else{
				alert("gagal disimpan, mungkin data sudah ada \n atau koneksi bermasalah");
				}	
			})
		}
	else {
		alert("harus diisi semua....");
	}	
}
function hapus_ujian(elm,id_ujian){
	var hapus = confirm("Dengan menghapus ujian ini berarti anda juga akan \n 'Menghapus seluruh data yang berkaitan dengan ujian ini ...'");
	if(hapus){
	var url = "hapus_data.php";		
	$.post(url,{id_nilai:id_ujian,id_nama:"id_ujian",table:"ujian"},function(hasil){
		if(hasil == 1){
			// hapus dibaris yang dihapus saja kawan
			$(elm).parent().parent().remove();
		//	$("#content").html("").load("daftar_ujian.php?id_mp=<?php echo $id_mp; ?>");
			}
		else {
			alert("gagal dihapus cek query anda .....");
			}	
		})
	}
}	
function edit_ujian(elm,id_ujian){
	var baris = $(elm).parent().parent();
	$(baris).parent().find("div.sedang_diedit").removeClass("sedang_diedit");
	$(baris).parent().find("div.telah_diedit").removeClass("telah_diedit");
	$(baris).addClass("sedang_diedit");
	// tampilkan data baris tersebut pada form
	var nama_ujian = $(baris).find("div.nama_ujian").text();
	var tanggal = $(baris).find("div.tanggal").text();
	var waktu = $(baris).find("div.waktu").text();
	waktu = waktu.split(" ");
	var ket = $(baris).find("div.ket").text();
	$("#nama_ujian").val(nama_ujian);
	$("#tanggal").val(tanggal);
	$("#waktu").val(waktu[0]);
	$("#keterangan").val(ket);
	$("#simpan_ujian").fadeOut();
	$("#update_ujian").fadeIn();
	// ambil id_ujian
	$("#update_ujian").data('id_ujian',id_ujian);
	}	
function batal_update(){
	$("div.sedang_diedit").removeClass("sedang_diedit");
	$("#update_ujian").fadeOut();
	$("#simpan_ujian").fadeIn();
	$(".inputan").each(function(){
		$(this).val($("#content").data($(this).attr("name")));
		})
	}	
function update_ujian(elm){
	var errornya = 0;
	$(".inputan").each(function(){
		if($(this).val() == ""){
			errornya++;
			$(this).focus();
			return false;
			}
		})	
	if(errornya == 0){
		//simpan ke database
		var data = $(elm).parent().parent().serializeArray();
		var url = "update_data.php";
		var tabel = "ujian";
		data.unshift({"name":"id_ujian","value":$("#update_ujian").data("id_ujian")});
		$.post(url,{data:data,table:tabel},function(hasil){
			if(hasil == 1){
				// update data pada baris yang diedit
				var baris = $("div.sedang_diedit");
				$(baris).find("div.nama_ujian").text($("#nama_ujian").val());
				$(baris).find("div.tanggal").text($("#tanggal").val());
				$(baris).find("div.waktu").text($("#waktu").val()+" Menit");
				$(baris).find("div.ket").text($("#keterangan").val());
				// hapus class sedang diedit dan tambahkan kelas telah diedit
				$(baris).removeClass("sedang_diedit").addClass("telah_diedit");
				}
			else{
				alert("gagal disimpan, mungkin data sudah ada \n atau koneksi bermasalah"+hasil);
				
				}	
			})			
		}
	else {
		alert("harus diisi semua....");
	}	
	}
$(function(){
	calendar.set("tanggal");
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
.daftar_ujian div.nama_ujian{
	width:15%;
	}
.daftar_ujian div.tanggal{
	width:8%;
	}
.daftar_ujian div.waktu{
	width:6%;
	}
.daftar_ujian div.jml_soal{
	width:5%;
	}	
.daftar_ujian div.ket{
	width:26%;
	}
</style>

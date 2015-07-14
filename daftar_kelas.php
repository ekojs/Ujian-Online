<?php
include_once "include/cek_session.php";
include_once "include/koneksi.php";
?>
<div class="row-fluid">
<form id="kelas">
<div class="span12">
	<div class="span2">
		<input type="text" name="nama_kelas" value="Nama Kelas" style="width: 200px" class="input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span3">	
		<span id="simpan_kelas" onclick="simpan_kelas(this)" class="btn btn-success"><i class="icon-plus icon-white"></i> Kelas</span>
		<span id="update_kelas" style="display:none">
		<span class="btn btn-success" onclick="update_kelas(this)"><i class="icon-ok icon-white"></i> Simpan</span>
		<span class="btn btn-warning" onclick="batal_update()"><i class="icon-remove icon-white"></i> Batal</span>
		</span>
	</div>
</div>
</form>
</div>

<div class="block">
     <div class="navbar navbar-inner block-header">
          <div class="muted pull-left">Daftar Kelas</div>
     </div>
     <div class="block-content collapse in">


			
			<?php
// ambil data kelas dari database
$mp_exe = mysql_query("select * from kelas");
$jml_kelas = mysql_num_rows($mp_exe);
if($jml_kelas > 0){
?>
		<?php
		while($data = mysql_fetch_assoc($mp_exe)){
			$jml_siswa = mysql_result(mysql_query("select count(*) from detail_kelas where id_kelas='".$data['id_kelas']."'"),0);
			echo "<div class='navbar navbar-inner block-header span3'><div class='muted pull-left'><strong>Kelas ".$data['nama_kelas']." </strong>";
			echo "Jumlah Santri ".$jml_siswa."</div>";
			echo "<br><br/><div onclick=\"lihat_siswa('".$data['id_kelas']."')\"><button class='btn btn-success'><i class='icon-white icon-plus'></i> Siswa</button></div>";
			echo "<div onclick=\"edit_kelas(this,'".$data['id_kelas']."')\"><button class='btn btn-warning'><i class='icon-white icon-pencil'></i> Kelas</button></div>";
			echo "<div onclick=\"hapus_kelas(this,'".$data['id_kelas']."')\"><button class='btn btn-danger'><i class='icon-white icon-trash'></i> Kelas</button></div>";
			echo "<br/></div>";
			}
			
		?>
<?php	
	}
else {
	echo "kelas Belum Dibuat";
	}	
?>

  </div>
</div>
</div>
<script>	
function lihat_siswa(id_kelas){
	// load content dengan data darin daftar_ujian.php
	$("#content").html(info_loading).load("daftar_siswa_perkelas.php?id_kelas="+id_kelas);
	$("body").data("back_url","daftar_kelas.php");
	}	
function edit_kelas(elm,id_kelas){
	var nama_kelas = $(elm).parent().find("strong").text();
	$(".sedang_diedit").removeClass("sedang_diedit");
	$(".telah_diedit").removeClass("telah_diedit");
	$(elm).parent().addClass("sedang_diedit");
	$("#kelas input[name=nama_kelas]").val(nama_kelas);
	// sembunyikan tombol simpan
	$("#simpan_kelas").fadeOut();
	$("#update_kelas").fadeIn();
	$("#update_kelas").data("id_kelas",id_kelas);
	}
function batal_update(){
	$(".sedang_diedit").removeClass("sedang_diedit");
	$("#update_kelas").fadeOut();
	$("#simpan_kelas").fadeIn();
	$(".inputan").each(function(){
		$(this).val($("#content").data($(this).attr("name")));
		})
	}	
function update_kelas(elm){
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
		var tabel = "kelas";
		data.unshift({"name":"id_kelas","value":$("#update_kelas").data("id_kelas")});
		$.post(url,{data:data,table:tabel},function(hasil){
			if(hasil == 1){
				// update data pada baris yang diedit
				var div_kelas = $(".sedang_diedit");
				$(div_kelas).find("li").text($("input[name=nama_kelas]").val());
				// hapus class sedang diedit dan tambahkan kelas telah diedit
				$(div_kelas).removeClass("sedang_diedit").addClass("telah_diedit");
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
function simpan_kelas(elm){
	var nama_kelas = $(elm).prev().val();
	if(nama_kelas != "" && nama_kelas != "nama kelas"){
		//simpan ke database
		var data = $(elm).parent().serializeArray();
		var url = "simpan_form.php";
		var tabel = "kelas";
		$.post(url,{data:data,tbl:tabel},function(hasil){
			if(hasil == 1){
				// reload content dengan halaman ini
				$("#content").html(info_loading).load("daftar_kelas.php");
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
function hapus_kelas(elm,id_kelas){
	$(".sedang_diedit").removeClass("sedang_diedit");
	$(elm).parent().addClass("sedang_diedit");
	var hapus = confirm("Dengan menghapus kelas ini berarti akan menghapus \n seluruh data yang berkaitan dengan kelas ini \n termasuk ujian dan nilai yang telah ada... ");
	if(hapus){
	var url = "hapus_data.php";		
	$.post(url,{id_nilai:id_kelas,id_nama:"id_kelas",table:"kelas"},function(hasil){
		if(hasil == 1){
			// hapus dibaris yang dihapus saja kawan
			$(elm).parent().remove();
			}
		else {
			alert("gagal dihapus cek query anda .....");
			}	
		})
	}
}	
</script>

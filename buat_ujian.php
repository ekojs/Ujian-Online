<?php
/*--------------------------------------------------------
 * Buat ujian untuk mata pelajaran tertentu
 *--------------------------------------------------------*/ 
include_once "include/koneksi.php"; 
$id_mp = $_REQUEST['id_mp'];
$nama_mp = mysql_result(mysql_query("select nama_mp from mapel where id_mp='".$id_mp."'"),0);
?>
<div>
<fieldset>
<legend>Buat Ujian Baru Mata Pelajaran <?php echo $nama_mp ?></legend>
<div id="stylized" class="select-bar">
<form method="post" title="ujian" onsubmit="return simpan(this)" action="simpan_form.php">
<input type="hidden" name="id_mp" id="id_mp" value="<?php echo $id_mp ?>" class="isian"/>
<label>Nama Ujian
<span class="small">Nama ujian yang dilaksanakan</span>
</label>
<input type="text" name="nama_ujian" id="nama_ujian" class="isian"/>
<span class="ket"></span>
<label >Tanggal Ujian 
<span class="small">Format (2020-12-30)</span>
</label>
<input type="text" name="tanggal" id="tanggal" class="isian" />
<span class="ket"></span>
<label >Waktu Ujian 
<span class="small">Dalam menit</span>
</label>
<input type="text" name="waktu" id="waktu" class="isian" />
<span class="ket"></span>
<label >Keterangan
<span class="small">Keterangan tambahan</span>
</label>
<input type="text" name="keterangan" id="keterangan" class="isian" />
<span class="ket"></span>
<button type="submit" class="isian">Simpan</button>
</form>
</div>
</fieldset>
</div>
<script>
function simpan(elm){
	var inputan = $(elm).find(".isian");	
	var data = $(elm).serializeArray(); //berupa JSON object
	var url = $(elm).attr('action');
	var tabel = $(elm).attr('title');
		for(i = 0; i < inputan.length - 1; i++){
				if($(inputan).eq(i).val() == ""){
					$(".ket").eq(i).html("harus diisi").css({"display":"block"});
					$(inputan).eq(i).focus();
					return false;
					}
				else {
					$(".ket").eq(i).empty().css({"display":"none"});
					}	
				}
		// simpan ke database		
		$.post(url,{tbl:tabel,data:data},function(hasil){
			if(hasil == 1){
			var tampil = "<div>Ujian Sudah dibuat</div>";
			$("#stylized").html(tampil);	
				}
			else{
				alert("gagal disimpan");
				}
			})
	return false;	
		}
</script>

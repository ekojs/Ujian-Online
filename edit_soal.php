<?php
/*--------------------------------------------------------
 * Buat soal ujian, bisa upload gambar dan rumus matematika
 *--------------------------------------------------------*/ 
include_once "include/koneksi.php"; 
$id_ujian = $_REQUEST["id_ujian"];
$id_kelas = $_REQUEST["id_kelas"];
$ujian_exe = mysql_query("select nama_ujian,id_mp from ujian where id_ujian='".$id_ujian."'");
while($data = mysql_fetch_assoc($ujian_exe)){
	$id_mp = $data['id_mp'];
	$nama_ujian = $data['nama_ujian'];	
	}
$soal_exe = mysql_query("select * from soal where id_ujian='".$id_ujian."' order by id_soal ");
echo "<div class='row-fluid' id='div_edit_soal'>
		<div class='block'>
			<div class='navbar navbar-inner block-header'>
				<div class='muted pull-left'>Edit Soal</div>
			</div>";
if(mysql_num_rows($soal_exe) > 0){
	// ambil semua pilihan jawaban dari database
	$sql_jawaban = "select * from pil_jawaban where id_soal in (select id_soal from soal where id_ujian='".$id_ujian."')";
	$sql_jawaban_exe = mysql_query($sql_jawaban);
	$pil_jawaban = array();
	while($d_jawaban = mysql_fetch_assoc($sql_jawaban_exe)){
		$pil_jawaban[$d_jawaban['id_soal']][$d_jawaban['id_jawaban']]['jawaban'] = $d_jawaban['jawaban'];
		$pil_jawaban[$d_jawaban['id_soal']][$d_jawaban['id_jawaban']]['status'] = $d_jawaban['status'];
		}
	$no = 1;
	echo "<br/><div class='soal_edit'>";
	echo "<div class='no_soal' style='margin-left:35px'><strong>No</strong></div>";
	echo "<div class='isi_soal_edit' style='margin-left:25px'><strong>Soal</strong></div>";	
	echo "<div class='jawaban_edit'><strong>Pilihan Jawaban</strong></div>";
	echo "</div>";
	while($data = mysql_fetch_assoc($soal_exe)){
?>		
	<div class='soal_edit'>
		<div class='no_soal' style='margin-left:35px'><?php echo $no++ ?><div style="padding:2px" class="tmb_del" onclick="return hapus_soal_ini(this)"><img src='image/del.png' title="Hapus soal ini"/></div></div>
		<div class='isi_soal_edit' style='margin-left:25px'>
		<span class='tombol info' style='margin-right:10px;float:right'></span>	
		<span style='margin-right:10px;float:right' onclick='edit_soalnya(this)'><img src='image/edit.png' /></span>
		<span style='margin-right:10px;float:right;display:none' onclick='simpan_soalnya(this)'><img src='image/save.png' /></span>
		<div id="<?php echo $data['id_soal'] ?>" >
		<?php echo $data['isi_soal'] ?>
		</div>
		</div>
		<div class='jawaban_edit'>
		<?php
		foreach($pil_jawaban[$data['id_soal']] as $id_jawaban => $jawaban){
			if($jawaban['status'] == '1'){
				$terpilih = "jwb_terpilih";
				$checked = "checked";
				}
			else {
				$terpilih ="";
				$checked = "";
				}	
			echo "<div class='div_pil_jawaban $terpilih'><span class='info' style='margin-right:10px;float:right'></span>";
			echo "<input disabled type='checkbox' style='float:left' $checked/>";
			echo "<span style='position:auto;margin-top:-1px;float:right' onclick='edit_jawaban(this)'><img src='image/edit.png' /></span>";
			echo "<span style='margin-right:10px;float:right;display:none' onclick='simpan_jawaban(this)'><img src='image/save.png' /></span>";
			echo "<div id='".$id_jawaban."' class='pil_jawaban'>".$jawaban['jawaban']."</div></div>";
			}
		?>
		</div>	
	</div>
<?php		
		}
	}
else {
	echo "soal masih kosong............";
	}	
?>
<br/></div><div class="row-fluid">
	<div class="btn btn-success kembali" onclick="kembali_lagi()"><i class="icon-white icon-circle-arrow-left"></i> Kembali</div>
</div>
</div>
<script type="text/javascript">
function edit_soalnya(elm){
	var id_soal = $(elm).next().next().attr("id");
	replaceDiv(id_soal);
	// sembunyikan tombol ini dan tampilkan tombol sebelahnya
	$(elm).fadeOut();
	$(elm).next().fadeIn();
	}
function simpan_soalnya(elm){
	var id_soal = $(elm).next().attr("id");
	hapus_kaji_editor(id_soal);
	var url = "update_data.php";
	var tabel = "soal";
	var data = [{"name":"id_soal","value":id_soal},{"name":"isi_soal","value":$("#"+id_soal).html()}];
	$(elm).parent().find(".info").html("sedang menyimpan .......").fadeIn();
	$.post(url,{data:data,table:tabel},function(hasil){
			if(hasil == 1){
			// sembunyikan tombol ini dan tampilkan tombol sebelahnya
				$(elm).fadeOut();
				$(elm).prev().fadeIn();
				$(elm).parent().find(".info").html("sudah disimpan .......").delay('3000').fadeOut();
				}
			else {
				alert("gagal disimpan....");
				}	
	})			
}	
function edit_jawaban(elm){
	var id_jawaban = $(elm).next().next().attr("id");
	replaceDiv(id_jawaban);
	// sembunyikan tombol ini dan tampilkan tombol sebelahnya
	$(elm).fadeOut();
	$(elm).next().fadeIn();
	}
function simpan_jawaban(elm){
	var id_jawaban = $(elm).next().attr("id");
	hapus_kaji_editor(id_jawaban);
	var url = "update_data.php";
	var tabel = "pil_jawaban";
	var data = [{"name":"id_jawaban","value":id_jawaban},{"name":"jawaban","value":$("#"+id_jawaban).html()}];
	$(elm).parent().find(".info").html("sedang menyimpan .......").fadeIn();
	$.post(url,{data:data,table:tabel},function(hasil){
			if(hasil == 1){
			// sembunyikan tombol ini dan tampilkan tombol sebelahnya
				$(elm).fadeOut();
				$(elm).prev().fadeIn();
				$(elm).parent().find(".info").html("sudah disimpan .......").delay('3000').fadeOut();
				}
			else {
				alert("gagal disimpan....");
				}	
	})			
}
function hapus_soal_ini(elm){
	var konfirmasi = confirm("Yakin akan menghapus soal ini .........");
	if(konfirmasi){
		var id_soal = $(elm).parent().next().find("div").attr("id");
		var url = "hapus_data.php";		
	$.post(url,{id_nilai:id_soal,id_nama:"id_soal",table:"soal"},function(hasil){
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
	else {
		return false;
		}	
	}
</script>
<style>	
#div_edit_soal{
	width:100%;
	margin:0 auto;
	}
.soal_edit{
	clear:both;
	border-bottom:1px solid gray;
//	margin:2px;
	overflow:auto;
	}
.soal_edit>div{
	float:left;
	}
.no_soal{
//	margin-right:5px;
	width:2%;
	}	
.isi_soal_edit{
	width:55%;
	margin:2px;
	}
.isi_soal_edit:hover{
	cursor:pointer;
	background:#E5E5E5;
	}				
.jwb_terpilih{
	background:#B6EFB6;
	}
.jawaban_edit{
	width:35%;
	}	
.div_pil_jawaban{
//	border-bottom:1px solid gray;
	padding:4px;
	clear:both;
	}
.div_pil_jawaban:hover{
	background:#E5E5E5;
	cursor:pointer;
	}			
.pil_jawaban{
	margin-left:22px;	
	}
.tmb_del:hover{
	cursor:pointer;
	}	
</style>

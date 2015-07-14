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
$soal_terakhir_exe = mysql_query("select id_soal from soal where id_ujian='".$id_ujian."' order by id_soal");
$jum_soal = mysql_num_rows($soal_terakhir_exe);
if($jum_soal > 0){
	// cari id_soal terakhir
	$arr_temp = array();
	while($data_soal = mysql_fetch_assoc($soal_terakhir_exe)){
		$soal_temp = explode("_",$data_soal['id_soal']);
		$nomer_soal = $soal_temp[1];
		array_push($arr_temp,$nomer_soal);
		}
	$soal_terakhir = max($arr_temp);
	}
else {
	$soal_terakhir = 0;
	}	

?>
<div class="row-fluid">
<script type="text/javascript">
function soal_kosong(id_ujian,soal_ke,jum_soal){
var jml_pil_jawaban = 5;
var nama_radio = "_"+id_ujian+"_"+soal_ke;	
var id_area = "_"+id_ujian+"_"+soal_ke;	
var soal_kosong =  "<div class='block-content collapse in'><div class='span12'><div class='soal_ujian'>";
	soal_kosong += "<div class='no_soal'><legend>Soal Ke "+jum_soal+"</legend></div>";
	soal_kosong += "<div class='isi_soal'>";
	soal_kosong += "<div class='div_editor'><span class='btn' onclick='hapus_kaji_editor(\""+id_area+"\")'>Preview</span>&nbsp;<span class='btn' onclick='replaceDiv(\""+id_area+"\")'>Text Editor</span></div>";
	soal_kosong += "<br/><div class='pertanyaan' id='"+id_area+"'>Tulis pertanyaan disini ...</div>";
	soal_kosong += "<div style='clear:both'></div>";
	for(var i = 0; i < jml_pil_jawaban;i++){
		soal_kosong += "<br/><div class='pilihan_jawaban'><input type='radio' name='"+nama_radio+"' onclick='jawab(this)'/>&nbsp;<textarea onchange='hapus_kunci_jawaban(this)'></textarea><span>&nbsp;<label class='btn' onclick='popup_editor(this)'>Text Editor</label>&nbsp;<label class='btn' onclick='preview(this)'>Preview</label></span></div>";	
		}
	soal_kosong += "<div><span class='btn tombol' onclick='tambah_jawaban(this)'>Tambah Jawaban</span>&nbsp;<span class='btn tombol' onclick='hapus_jawaban(this)'>Hapus Jawaban</span></div>";	
	soal_kosong += "<br/><div><strong>Kunci Jawaban :</strong>";
	soal_kosong += "<div class='alert alert-info kunci_jawaban'></div>";
	soal_kosong += "</div>";	
	soal_kosong += "<br/><div><span class='btn btn-success tombol simpan' onclick='simpan(this)'><i class='icon-white icon-ok'></i> Simpan</span>&nbsp;<span class='btn btn-warning tombol reset' onclick='reset(this)'><i class='icon-white icon-repeat'></i> Reset</span></div>";	
	soal_kosong += "</div></div><br><br />";
return soal_kosong;		
}
function tambah_jawaban(elm){
//	var pil_jawaban_baru ="<div class='pilihan_jawaban'><input type='radio' name='"+nama_radio+"' onclick='jawab(this)'/><textarea onchange='hapus_kunci_jawaban(this)'></textarea><span><label onclick='popup_editor(this)'>Text Editor</label><label onclick='preview(this)'>Preview</label></span></div>";
	$(elm).parent().parent().find('.pilihan_jawaban').last().clone().insertBefore($(elm).parent());
	}
function hapus_jawaban(elm){
//	var pil_jawaban_baru ="<div class='pilihan_jawaban'><input type='radio' name='"+nama_radio+"' onclick='jawab(this)'/><textarea onchange='hapus_kunci_jawaban(this)'></textarea><span><label onclick='popup_editor(this)'>Text Editor</label><label onclick='preview(this)'>Preview</label></span></div>";
	$(elm).parent().parent().find('.pilihan_jawaban').last().remove();
	}	
function tambah_soal(jumlah){
	var jum_awal = "<?php echo $jum_soal ?>";
	var soal_terakhir = "<?php echo $soal_terakhir ?>";
	for(var i = 0; i < jumlah; i++){
	var id_ujian = "<?php echo $id_ujian ?>";
	var soal_ke = $(".soal_ujian").length + 1 + parseInt(soal_terakhir);
	var id_area = "_"+id_ujian+"_"+soal_ke;	
	var jum_soal_sekarang = $(".soal_ujian").length + 1 + parseInt(jum_awal);
	var soalnya = soal_kosong(id_ujian,soal_ke,jum_soal_sekarang);
	$(soalnya).appendTo("#tempat_soal");
	replaceDiv(id_area);
	// info untuk jumlah soal
	$("#info_jml_soal").text(jum_soal_sekarang);
	}
}
function jawab(elm){
	$(elm).parent().parent().find("div.kunci_jawaban").html($(elm).next().val());
	}	
function hapus_kunci_jawaban(elm){
	$(elm).parent().parent().find("div.kunci_jawaban").empty();
	}
function simpan(elm){
	var isi_soal = $(elm).parents("div.isi_soal");
	// pilihan jawaban dan kunci jawaban gak boleh kosong
	var pilihan_jawaban = new Array();
	var error = 0;
	$(isi_soal).find(".pilihan_jawaban>textarea").each(function(index){
		if($(this).val() == ""){
			$(this).css({"background":"#F4C3C2"});
			error++;
			}
		else{
			$(this).css({"background":"#FFFFFF"});
			// yang radio buttonnya dipilih berarti jawaban yang benar
			var temp_status = 0; // 0 = false
			if($(this).prev().is(":checked")){
				temp_status = 1;
				}
			var temp_jawaban = [$(this).val(),temp_status];	
			pilihan_jawaban.push(temp_jawaban);		
			}
		});
	// ambil pertanyaan tapi destroy dulu ckeditor biar lebih mudah
	$(isi_soal).find(".div_editor span").eq(0).click();
	var pertanyaan = $(isi_soal).find(".pertanyaan").eq(0).html();
	var kunci_jawaban = $(isi_soal).find(".kunci_jawaban:first");
	// jika sudah lengkap semua simpan ke database
	if(error == 0 && $(kunci_jawaban).html() != ""){
	// id_ujian diambil dari nama radio button pada pilihan jawaban
	var nama_radio = $(isi_soal).find(":radio").eq(0).attr("name");
	// id untuk div informasi ketika menyimpan soal
	var id_info = "info_"+nama_radio;
	nama_radio = nama_radio.split("_");
	var id_ujian = nama_radio['1'];
	var id_soal = id_ujian+"_"+nama_radio['2'];
	var tinggi_div_soal = $(isi_soal).parent().outerHeight();
	var lebar_div_soal = $(isi_soal).parent().outerWidth();
	var posisi = $(isi_soal).parent().position();
	var div_overlay = "<div style='position:absolute;top:"+posisi.top+";left:"+posisi.left;
		div_overlay +=";width:"+lebar_div_soal+"px;height:"+tinggi_div_soal+";background:#FFFFFF;opacity:0.6' >";
		div_overlay +="</div>";
		div_overlay +="<div id='"+id_info+"' style='position:absolute;border:1px solid #000000;font-weight:bolder";
		div_overlay +=";background:#FFFFFF;padding:6px;border:1px solid #00FF00;border-radius:3px;text-align:center' >";
		div_overlay +="<span class='loading'>Sedang menyimpan ...........</span></div>";	
	$(div_overlay).appendTo("#tempat_soal");
	// letakkan informasi pada div id=id_info tepat ditengah soal
	var tinggi_info = $("#"+id_info).outerHeight();
	var lebar_info = $("#"+id_info).outerWidth();
	var atas = (parseInt(posisi.top) + (tinggi_div_soal - tinggi_info)/2)+"px";
	var kiri = (lebar_div_soal - lebar_info)/2+"px";
	$("#"+id_info).css({"top":atas,"left":kiri});
	// simpan soal ke database
	var data_kirim = [id_soal,id_ujian,pertanyaan,pilihan_jawaban];	
	var url = "simpan_soal.php";
	$.post(url,{data:data_kirim},function(hasil){
		if(hasil == 1){
			// info sukses disimpan
			$("#"+id_info).html("<span class='sukses'>Sudah disimpan ..........</span>");
			}
		else {
			// tampilkan info coba simpan lagi
			$("#"+id_info).html("<div>Gagal disimpan, mungkin jaringan sedang down ..........</div><div style='margin:0 auto;width:80px;border:2px solid green' class='tombol' onclick=\"simpan_lagi(this,'"+id_info+"')\">Coba lagi</div>");
			}	
		})

	}
	else{
		alert("ada yang kosong atau belum memilih jawaban");
		if($(kunci_jawaban).html() == ""){
			$(kunci_jawaban).css({"background":"#F4C3C2"});
			}
	}
}
function simpan_lagi(elm,info_soal){
	// id elemen ini adalah info_id_soal, id soal aja
	var id_soal = info_soal.substr(5);
	// hapus overlay
	$(elm).parent().parent().remove();
	// klik kembali tombol simpan
	$("#"+id_soal).parent().find("div input.tombol").eq(0).click();
	}			
function reset(elm){
	var isi_soal = $(elm).parents("div.isi_soal");
	$(isi_soal).find("textarea").val("");
	$(isi_soal).find(".kunci_jawaban").empty();
	}
function preview(elm){
	var data_textarea = $(elm).parent().prev().val();
	// tutup semua layar monitor
	var lebar_layar = $(window).width();
	var tinggi_layar = $(document).height();
	var overlay = "<div id='overlay' style=\"width:"+lebar_layar+"px;";
		overlay +="position:absolute;top:0px;background:#FFFFFF;z-index:25\">";
		overlay +="<div style=\"border:1px solid #000000;width:65%;position:absolute;padding:10px\"><div id='popup_editor'>"+data_textarea+"</div>";
		overlay +="<div style='margin-top:10px'>";
		overlay +="<span class='btn btn-warning' onclick='tutup_texteditor(this)'>Tutup</span></div></div></div>";
	$(overlay).appendTo("#content");
	var atas = (($(window).height() - $("#popup_editor").parent().height()) / 2) + $(window).scrollTop();
	var kiri = (lebar_layar - $("#popup_editor").parent().width()) / 2 + $(window).scrollLeft();
	$("#popup_editor").parent().css({"top":atas+"px","left":kiri+"px"});
	// tinggi overlay disesuaikan
	$("#overlay").css({"height":$(document).height()+"px"});
	}	
function popup_editor(elm){
	// tambahkan elemen pemanggil dengan id pemanggil_editor
	$(elm).attr('id','pemanggil_editor');
	var data_textarea = $(elm).parent().prev().val();
	// tutup semua layar monitor
	var lebar_layar = $(window).width();
	var tinggi_layar = $(document).height();
	var overlay = "<div id='overlay' style=\"width:"+lebar_layar+"px;";
		overlay +="position:absolute;top:0px;background:#FFFFFF;z-index:25\">";
		overlay +="<div style=\"width:65%;position:absolute;padding:10px\"><div id='popup_editor'>"+data_textarea+"</div>";
		overlay +="<div style='margin-top:10px'><span class='btn btn-primary tombol edit' onclick='sisipke_textarea(this)'>Sisipkan</span>";
		overlay +="&nbsp;<span class='btn btn-warning tombol batal' onclick='tutup_texteditor(this)'>Tutup</span></div></div></div>";
	$(overlay).appendTo("#content");
	replaceDiv("popup_editor");	
	var atas = (($(window).height() - $("#popup_editor").parent().height()) / 2) + $(window).scrollTop();
	var kiri = (lebar_layar - $("#popup_editor").parent().width()) / 2 + $(window).scrollLeft();
	$("#popup_editor").parent().css({"top":atas+"px","left":kiri+"px"});
	// tinggi overlay disesuaikan
	$("#overlay").css({"height":$(document).height()+"px"});
	}
function sisipke_textarea(elm){
	hapus_kaji_editor("popup_editor");
	var data = $("#popup_editor").html();
	// pemanggil editor
	var pemanggil = $("#pemanggil_editor");
	// textarea yang diisi data
	$(pemanggil).parent().prev().val(data).change();
	$(elm).parent().parent().parent().remove();
	// hapus elemen id dari pemanggil
	$(pemanggil).removeAttr("id");
	}	
function tutup_texteditor(elm){
	hapus_kaji_editor("popup_editor");
	$(elm).parent().parent().parent().remove();
	var pemanggil = $("#pemanggil_editor");
	$(pemanggil).removeAttr("id");
	}
$(function(){
	$("#t_soal").click();
})	
</script>
<div id="t_soal" class="btn btn-success tombol tambah" onclick="tambah_soal(1)">
<i class="icon-white icon-plus-sign"></i> Tambah Soal &nbsp;<span id="info_jml_soal" class="badge badge-warning"> 0</span>
</div>
<span class="btn btn-success kembali" onclick="kembali_lagi()"><i class="icon-white icon-circle-arrow-left"></i> Kembali</span>

<div id="tempat_soal" class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Tambahkan soal untuk ujian <?php echo $nama_ujian ?></div>
			</div>
</div>			

<?php
/*--------------------------------------------------------
 * Buat ujian untuk mata pelajaran tertentu
 *--------------------------------------------------------*/ 
include_once "include/cek_session.php";
include_once "include/koneksi.php"; 
include_once "include/fungsi.php"; 
?>
<script src="js/ajaxupload.js"></script>
<div class="row-fluid">
<div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Import Data Siswa</div>
                            </div>
                            <div class="block-content collapse in">
                                         <div class="control-group">
                                          <div class="controls">
                                            <input id="input_upload" class="input-file uniform_on" id="fileInput" type="file">
                                          </div>
                                          <p class="help-block">Unduh contoh file<a href='siswa.xls'> disini</a></p>
                                        </div>
                             </div>
</div>

<form id="f_siswa">
<div class="span12">
	<div class="span2">
		<input type="text" name="nis" value="nomer daftar" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span2">
		<input type="text" name="nama" value="nama siswa" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span2">
		<input type="text" name="alamat" value="alamat siswa" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span2">
		<input type="text" name="agama" readonly value="Islam" style="width: 200px" class="inputan input-block-level"/>
	</div>
	<div class="span4">
		<span id="simpan_siswa" onclick="simpan_siswa(this)" class="btn btn-success"><i class="icon-plus icon-white"></i> Siswa</span>
		<span id="update_siswa" style="display:none">
		<span class="btn btn-success" onclick="update_siswa(this)"><i class="icon-ok icon-white"></i> Simpan</span>
		<span class="btn btn-warning" onclick="batal_update()"><i class="icon-remove icon-white"></i> Batal</span>
		</span>
		<span class='tombol info'></span>	
	</div>
</div>
</form>
</div>
	<?php
	$perhal = 10; // jumlah data yang ditampilkan dalam tabel
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
	$index_hal = ($hal - 1 ) * $perhal ;
	$sql_all="select * from siswa";
	$sql_exe_all = mysql_query($sql_all);
	$jml_all = mysql_num_rows($sql_exe_all);
	$jml_hal = round($jml_all / $perhal); // hitung jumlah seluruh halaman
	$sql_tampil="select * from siswa limit ".$index_hal.",".$perhal;
	$sql_exe_tampil = mysql_query($sql_tampil);
//	echo $sql_tampil;
	if(mysql_num_rows($sql_exe_tampil) > 0){
	echo "<div class='block'>
			<div class='navbar navbar-inner block-header'>
				<div class='muted pull-left'>Daftar Siswa Peserta Ujian</div>
			</div>";
	echo "<div class='block-content collapse in'>
			<div class='span12'>                                    
				<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered'>";	
	// buat headernya kawan
	echo "<thead>";
	echo "<tr>";
	echo "<th>no</th>";
	$jum_kolom = mysql_num_fields($sql_exe_tampil);
	for($i = 0; $i < $jum_kolom; $i++){
		echo "<th>".mysql_field_name($sql_exe_tampil,$i)."</th>";
		}
	echo "<th>aksi</th>";	
	echo "</tr>";
	echo "</thead>";
	echo "<tbody id='daftar_siswa'>";
	$no = $index_hal + 1;
	while($data_baris = mysql_fetch_assoc($sql_exe_tampil)){
		echo "<tr>";
		echo "<td>".$no++."</td>";
		foreach($data_baris as $data){
			echo "<td>".$data."</td>";
			}
		echo "<td><button onclick='edit_siswa(this)' class='btn btn-success'><i class='icon-pencil icon-white'></i></button>								
				  <button onclick='hapus_siswa(this,\"".$data_baris['nis']."\")' class='btn btn-danger'><i class='icon-trash icon-white'></i></button>
			  </td>";	
		echo "</tr>";
		}
	echo "</tbody>";
	echo "</table>";
		// tampilkan pagingnya
	echo "<div class='pagination'>"; 	
	echo "<ul>";
		for ($i = 1; $i <= $jml_hal ; $i++)
			{
				if($i == $hal){
					echo "<li><a onclick='load_daftar_siswa(this)'>".$i."</a></li>";
					}
				else {	
					echo "<li><a onclick='load_daftar_siswa(this)'>".$i."</a></li>";
					}
			}
	echo "</ul>";
	echo "</div>";	
		}
	else {
		echo "Data masih kosong, diisi dulu ya ........";
		}	 
	?>
</div>
<script >
function simpan_siswa(elm){
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
		var tabel = "siswa";
		$.post(url,{data:data,tbl:tabel},function(hasil){
			if(hasil == 1){
				// reload content dengan halaman ini
			//	$("#content").html("").load("daftar_siswa.php");
			var jml_baris = $("table.listing tr").length;
			var data_baru = "<td>"+jml_baris+"</td>";
				$(".inputan").each(function(index){
					data_baru +="<td>"+$(this).val()+"</td>";
					});
			data_baru +="<td><span class='tombol edit' onclick='edit_siswa(this)'>Siswa</span>&nbsp;<span class='tombol hapus' onclick='hapus_siswa(this,\""+$(".inputan").eq(0).val()+"\")'>Siswa</span></td>";		
			var baris_baru = "<tr>"+data_baru+"</tr>";		
			$(baris_baru).insertAfter($("table.listing tr:last"));
			$(".info").html("<div class='alert alert-success'>Sudah disimpan... </div>").fadeIn('slow').delay("2000").fadeOut();
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
function edit_siswa(elm){
	var baris = $(elm).parent().parent();
	// hapus kelas sedang diedit pada baris lainnya
	$(baris).parent().find("td.sedang_diedit").removeClass("sedang_diedit");
	$(baris).children().addClass("sedang_diedit");
	var inputan = $(".inputan");
	$(baris).find("td").not(":first").each(function(index){
		$(inputan).eq(index).val($(this).text());
		})
	// nis siswa jadikan readonly supaya gak bisa diedit
	$(inputan).eq(0).attr("readonly",true);	
	$("#update_siswa").fadeIn();
	$("#simpan_siswa").fadeOut();
	}		
function update_siswa(elm){
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
		var tabel = "siswa";
		//data.unshift({"name":"id_ujian","value":$("#update_ujian").data("id_ujian")});
		$.post(url,{data:data,table:tabel},function(hasil){
			if(hasil == 1){
				// update data pada baris yang diedit
				var kolom_data = $("td.sedang_diedit").not(":first");
				$(".inputan").each(function(index){
					$(kolom_data).eq(index).text($(this).val());
					});
				// hapus class sedang diedit dan tambahkan kelas telah diedit
				$(kolom_data).removeClass("sedang_diedit").addClass("telah_diedit");
				$(".info").html("<span class='alert alert-success'><i class='icon-info-sign'></i> Sudah disimpan ...</span>").fadeIn('slow').delay("2000").fadeOut();
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
function batal_update(){
	$("td.sedang_diedit").removeClass("sedang_diedit");
	$("#update_siswa").fadeOut();
	$("#simpan_siswa").fadeIn();
	$(".inputan").each(function(){
		$(this).val($("#content").data("awal_"+$(this).attr("name")));
		})
	$(".inputan").eq(0).attr("readonly",false);		
	}
function hapus_siswa(elm,nis){
	var hapus = confirm("Yakin akan menghapus siswa dengan nis = "+nis);
	if(hapus){
	var url = "hapus_data.php";		
	$.post(url,{id_nilai:nis,id_nama:"nis",table:"siswa"},function(hasil){
		if(hasil == 1){
			// hapus dibaris yang dihapus saja kawan
			$(elm).parent().parent().remove();
			}
		else {
			alert("gagal dihapus cek query anda .....");
			}	
		})
	}
}		
function load_daftar_siswa(elm){
	var info_loading = "<div style='font-size:110%;font-style:italic;font-weight:bolder;width:150px;margin:0 auto;' class='tombol loading'>Sedang proses .............</div>";	
	var hal = $(elm).text();
	var url = "daftar_siswa.php?hal="+hal;
	$("#content").html(info_loading).load(url);
	}
$(function(){
	$(".inputan").each(function(){
		$("#content").data("awal_"+$(this).attr("name"),$(this).val());
		});
	            new AjaxUpload('#input_upload', {
                        action: 'import_xls.php',
                        onComplete: function(file, response){                   
							alert(response);
						}
		});
 })	
		
</script>

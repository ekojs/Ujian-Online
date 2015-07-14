<?php
/*--------------------------------------------------------
 * Buat ujian untuk mata pelajaran tertentu
 *--------------------------------------------------------*/ 
include_once "include/cek_session.php";
include_once "include/koneksi.php"; 
include_once "include/fungsi.php"; 
?>
<div class="row-fluid">
<form id="f_guru">
<div class="span12">
	<div class="span2">
		<input type="text" name="nis" value="nomer daftar" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span2">	
		<input type="text" name="nama" value="nama guru" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span2">	
		<input type="text" name="alamat" value="alamat guru" style="width: 200px" class="inputan input-block-level" onfocus="bersihkan(this)" onblur="kembali_semula(this)"/>
	</div>
	<div class="span2">	
		<input type="text" name="agama" readonly value="Islam" style="width: 200px" class="inputan input-block-level"/>
	</div>
	<div class="span4">
		<span id="simpan_guru" onclick="simpan_guru(this)" class="btn btn-success"><i class="icon-plus icon-white"></i> Guru</span>
		<span id="update_guru" style="display:none">
		<span class="btn btn-success" onclick="update_guru(this)"><i class="icon-ok icon-white"></i> Simpan</span>
		<span class="btn btn-warning" onclick="batal_update()"><i class="icon-remove icon-white"></i> Batal</span>
		</span>
		<span class='tombol info'></span>
	</div>
</div>	
</form>
</div>
	<?php
	$perhal = 5; // jumlah data yang ditampilkan dalam tabel
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
	$index_hal = ($hal - 1 ) * $perhal ;
	$sql_all="select * from guru";
	$sql_exe_all = mysql_query($sql_all);
	$jml_all = mysql_num_rows($sql_exe_all);
	$jml_hal = round($jml_all / $perhal); // hitung jumlah seluruh halaman
	$sql_tampil="select * from guru limit ".$index_hal.",".$perhal;
	$sql_exe_tampil = mysql_query($sql_tampil);
//	echo $sql_tampil;
	if(mysql_num_rows($sql_exe_tampil) > 0){
	echo "<div class='block'>
			<div class='navbar navbar-inner block-header'>
				<div class='muted pull-left'>Daftar Guru Mengajar</div>
			</div>";	
	// buat headernya kawan
	echo "<div class='block-content collapse in'>
			<div class='span12'>                                    
				<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered'>
					<thead>
						<tr>
							<th>no</th>";	
								$jum_kolom = mysql_num_fields($sql_exe_tampil);
								for($i = 0; $i < $jum_kolom; $i++){
								echo "<th>".mysql_field_name($sql_exe_tampil,$i)."</th>";
								}
							echo "<th>aksi</th>
						</tr>
					</thead>";
				echo "<tbody id='daftar_guru'>";
				$no = $index_hal + 1;
				while($data_baris = mysql_fetch_assoc($sql_exe_tampil)){
				echo "<tr class='odd gradeX'>";
				echo "<td>".$no++."</td>";
				foreach($data_baris as $data){
				echo "<td>".$data."</td>";
					}
				echo "<td>											
						<button onclick='edit_guru(this)' class='btn btn-success'><i class='icon-pencil icon-white'></i></button>								
						<button onclick='hapus_guru(this,\"".$data_baris['nis']."\")' class='btn btn-danger'><i class='icon-trash icon-white'></i></button>
					  </td>";	
				echo "</tr>";
					}
				echo "</tbody>";
				echo "</table>";
		// tampilkan pagingnya
	echo "<div class='pagination'>
				<ul>";		
				for ($i = 1; $i <= $jml_hal ; $i++)
			{
				if($i == $hal){
					echo "<li><a onclick='load_daftar_guru(this)'>".$i."</a></li>";
					}
				else {	
					echo "<li><a onclick='load_daftar_guru(this)'>".$i."</a></li>";
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

<script src="vendors/datatables/js/jquery.dataTables.min.js"></script>
<script >
function simpan_guru(elm){
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
		var tabel = "guru";
		$.post(url,{data:data,tbl:tabel},function(hasil){
			if(hasil == 1){
				// reload content dengan halaman ini
			//	$("#content").html("").load("daftar_guru.php");
			var jml_baris = $("table.listing tr").length;
			var data_baru = "<td>"+jml_baris+"</td>";
				$(".inputan").each(function(index){
					data_baru +="<td>"+$(this).val()+"</td>";
					});
			data_baru +="<td><span class='tombol edit' onclick='edit_guru(this)'>guru</span>&nbsp;<span class='tombol hapus' onclick='hapus_guru(this,\""+$(".inputan").eq(0).val()+"\")'>guru</span></td>";		
			var baris_baru = "<tr>"+data_baru+"</tr>";		
			$(baris_baru).insertAfter($("table.listing tr:last"));
			$(".info").html("<span class='alert alert-success'><i class='icon-info-sign'></i> Sudah disimpan ...</span>").fadeIn('slow').delay("2000").fadeOut();
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
function edit_guru(elm){
	var baris = $(elm).parent().parent();
	// hapus kelas sedang diedit pada baris lainnya
	$(baris).parent().find("td.sedang_diedit").removeClass("sedang_diedit");
	$(baris).children().addClass("sedang_diedit");
	var inputan = $(".inputan");
	$(baris).find("td").not(":first").each(function(index){
		$(inputan).eq(index).val($(this).text());
		})
	// nis guru jadikan readonly supaya gak bisa diedit
	$(inputan).eq(0).attr("readonly",true);	
	$("#update_guru").fadeIn();
	$("#simpan_guru").fadeOut();
	}		
function update_guru(elm){
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
		var tabel = "guru";
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
	$("#update_guru").fadeOut();
	$("#simpan_guru").fadeIn();
	$(".inputan").each(function(){
		$(this).val($("#content").data("awal_"+$(this).attr("name")));
		})
	$(".inputan").eq(0).attr("readonly",false);		
	}
function hapus_guru(elm,nis){
	var hapus = confirm("Yakin akan menghapus guru dengan nis = "+nis);
	if(hapus){
	var url = "hapus_data.php";		
	$.post(url,{id_nilai:nis,id_nama:"nis",table:"guru"},function(hasil){
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
function load_daftar_guru(elm){
	var info_loading = "<div style='font-size:110%;font-style:italic;font-weight:bolder;width:150px;margin:0 auto;' class='tombol loading'>Sedang proses .............</div>";	
	var hal = $(elm).text();
	var url = "daftar_guru.php?hal="+hal;
	$("#content").html(info_loading).load(url);
	}
$(function(){
	$(".inputan").each(function(){
		$("#content").data("awal_"+$(this).attr("name"),$(this).val());
		});
 })	
		
</script>



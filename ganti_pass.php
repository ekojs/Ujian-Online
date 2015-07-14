<?php
session_start();
include_once "include/koneksi.php";
?>
<div class="row-fluid">
<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Ganti Password</div>
			</div>
			
<fieldset>

<?php
// ambil data mata pelajaran dari database
$nis = $_SESSION['nis_kj'];
?>
<div class="block-content collapse in">
	<div class="span12">
		<form class="form-horizontal">
			<legend>Form Ganti Password</legend>
			<fieldset>
				<div class="alert alert-success">
					<div class="tombol info"></div>
				</div>
                <div class="control-group">
					<label class="control-label">Password Lama</label>
                    <div class="controls">
						<input class="input-xlarge" type="password" name="pass_lama"/>
                    </div>
                </div>
                <div class="control-group">
					<label class="control-label">Password Baru</label>
                    <div class="controls">
						<input class="input-xlarge" type="password" name="pass_baru"/>
                    </div>
                </div>
                <div class="control-group">
					<label class="control-label">Ulangi Password</label>
                    <div class="controls">
						<input class="input-xlarge" type="password" name="ulangi_pass"/>
                    </div>
                </div>
                <div class="form-actions">
					<button type="button" class="btn btn-primary" onclick='update_pass()'>Simpan</button>
                </div>
			</fieldset>
         </form>
      </div>
   </div>                          
</div>
<script type="text/javascript">
function update_pass(){
	var errornya = 0;
	var info="";
	$(".inputan").each(function(){
		if($(this).val() == ""){
			errornya++;
			$(this).focus();
			info = "Ada yang kosong, harus diisi semua";
			return false;
			}
		})	
	// cek apakah password baru dan ulangi password adalah sama
	if($("input[name=pass_baru]").val() == $("input[name=ulangi_pass]").val()){
	
		}	
	else {
		var info = "Password baru dan ulangi password tidak sama ....."+$("input[name=pass_baru]").val()+"...."+$("input[name=ulangi_pass]").val();
		errornya++;	
		}
	if(errornya == 0){		
		//simpan ke database
		var url = "cek_ganti_pass.php";
		$.post(url,{pass_lama:$("input[name=pass_lama]").val(),pass_baru:$("input[name=pass_baru]").val()},function(hasil){
			if(hasil == 1){
				// update data pada baris yang diedit
				
				$(".info").html("Sudah disimpan ...").fadeIn('slow').delay("5000").fadeOut();
				}
			else{
				$(".info").html(hasil).fadeIn("slow").delay("5000").fadeOut("slow");
				}	
			})			
		}
	else {
		$(".info").html(info).fadeIn("slow").delay("5000").fadeOut("slow");
	}	
}
$(function(){
	$("input:first").focus();
	})
</script>

<?php
session_start();
include_once "include/koneksi.php";
?>
<div class="row-fluid">
<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Data Pribadi</div>
			</div>
<?php
// ambil data mata pelajaran dari database
$tabel = $_SESSION['level_kj'];
$nis = $_SESSION['nis_kj'];
$profil_exe = mysql_query("select * from ".$tabel." where nis='".$nis."'");
$data_profil = mysql_fetch_assoc($profil_exe);
foreach($data_profil as $index => $nilai){
	echo "<div class='block-content collapse in'>
			<div class='span12'>                                    
				<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered'>
					<thead>
						<tr>
							<td width='150'>".ucwords($index)."</td>
							<td>".ucwords($nilai)."</td>
						</tr>										
					</thead>
				</table>
			</div>
		  </div>";
  	  	}
	?>
</div>
</div>
					
				

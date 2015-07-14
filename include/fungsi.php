<?php
//untuk fungsi serialize
function buatStringDariJquey($arr){
	$data = trim($arr);//hapus spasi didepan dan belakang	
		$data_ar = explode('&',$data); //pecah data menjadi array
		foreach($data_ar as $id => $nilai){
			$nilai_ar = explode('=',$nilai);
			$ids[]=$nilai_ar[0]; //ambil idnya saja 
			$nilais[]=$nilai_ar[1]; //ambil nilainya saja
			}
		$nama_kolom='';	
		for($i = 0;$i < count($ids); $i++){
			$nama_kolom .=$ids[$i].",";
			}
		$nama_kolom = substr($nama_kolom,0,strlen($nama_kolom) - 1);
		$nilainya='';	
		for($i = 0;$i < count($nilais); $i++){
			$nilainya .="'".$nilais[$i]."',";
			}
		$nilainya = substr($nilainya,0,strlen($nilainya) - 1);
		return $nama_kolom.'&'.$nilainya;
	}
//fungsi ubah array menjadi string untuk dijadikan parameter pada query
//menjadi bentuk 'nilai1','nilai2','nilai3' 
function buatStringNilai($data){
	$nilainya='';
	for($i = 0;$i < count($data); $i++){
			$nilainya .="'".$data[$i]."',";
			}
		$nilainya = substr($nilainya,0,strlen($nilainya) - 1);
		return $nilainya;
	}
	//fungsi ubah array menjadi string untuk dijadikan parameter pada query
//menjadi bentuk nilai1,nilai2,nilai3 
function buatStringKolom($data){
	$nilainya='';
	for($i = 0;$i < count($data); $i++){
			$nilainya .=$data[$i].",";
			}
		$nilainya = substr($nilainya,0,strlen($nilainya) - 1);
		return $nilainya;
	}
//panjang kedua array harus sama, nilai pertama selalu primary key
function buatStringUpdate($nama,$nilai){
	$hasil='';
	for($i = 0; $i < count($nama); $i++){
		$hasil .= $nama[$i]."= '".$nilai[$i]."',";
		}
	$hasil = substr($hasil,0,strlen($hasil) - 1);
	$hasil .=" where ".$nama[0]."= '".$nilai[0]."'";	
	return $hasil;
	}
function buatStringUpdate2($nama,$nilai){
	$hasil='';
	for($i = 0; $i < count($nama); $i++){
		$hasil .= $nama[$i]."= '".$nilai[$i]."',";
		}
	$hasil = substr($hasil,0,strlen($hasil) - 1);
	return $hasil;
	}	
function buatStringUpdateId($nama,$nilai){
	$nilai_id = array_shift($nilai);
	$nama_id = array_shift($nama);
	$hasil='';
	for($i = 0; $i < count($nama); $i++){
		$hasil .= $nama[$i]."= '".$nilai[$i]."',";
		}
	$hasil = substr($hasil,0,strlen($hasil) - 1);
	$hasil .=" where ".$nama_id."= '".$nilai_id."'";	
	return $hasil;
	}

function tgl_sekarang(){
	$today = date("d-m-Y");
	return $today;
	}
function ribuan($angka){
	return number_format($angka);
	}
function buat_form($nama_tabel){
$action = 'input.php'; 
$data .= "<form action='".$action."' method='POST'>
		<table border='0' align='center'>
		<caption>Isi tabel $nama_tabel </caption>
		<input name='tabel' type='hidden' value='".$nama_tabel."' />";
$sql="select * from $nama_tabel";
// echo $sql;
$hasil = mysql_query($sql);
// $field = new Array();
for ($j = 0; $j < mysql_num_fields($hasil); ++$j) {
// $table = mysql_field_table($hasil, $i);
$field[$j] = mysql_field_name($hasil, $j);
//printf(" $table "." : "." $field ");
$data.= "<tr><td>
$field[$j] </td><td><input type='text' size='20' name='$field[$j]'>
</td></tr>";
}
$data .= "<tr><td colspan='2' align='center'><input type='submit' value='simpan' name='simpan'>
<input type='reset' value='batal'></td></tr>";
$data .= "</table></form>";
return $data;	
	}
function buat_list($nama,$tabel,$id_nilai = 0,$id_tampil = 0){
	$sql = "select * from ".$tabel;
	$sql_exe = mysql_query($sql);
	if($sql_exe){
		echo "<select name=".$nama.">";
		echo "<option value=''>Pilih dulu</option>";
		$baris = mysql_num_rows($sql_exe);
		if( $baris > 0 ) {
		while ($data = mysql_fetch_row($sql_exe)){
			echo "<option value=".$data[$id_nilai].">".$data[$id_tampil]."</option>";
			}	
		  }
		echo "</select>";
		}	
		
	}
function buat_listId($nama,$tabel,$id,$id_nilai = 0,$id_tampil = 0){
	$sql = "select * from ".$tabel;
	$sql_exe = mysql_query($sql);
	if($sql_exe){
		$hasil .= "<select name=".$nama.">";
		$baris = mysql_num_rows($sql_exe);
		if( $baris > 0 ) {
		while ($data = mysql_fetch_row($sql_exe)){
			if($id == $data[$id_nilai]){
				$selected = "selected";
				}
			else {
				$selected = "";
				}	
			$hasil .="<option value=".$data[$id_nilai]." ".$selected." >".$data[$id_tampil]."</option>";
			}	
		  }
		$hasil .="</select>";
		}	
return $hasil;		
	}
function login(){
$login ="<div align='center' class='login'>
<form action='' method='Post' >
<table>
<TR><TD><input type='text' id='user' value='07622053' /></TD></TR>
<TR><TD><input type='password' id='pass' value='ahmad' /></TD></TR>
</table>
</form>
</div>";
return $login;
}
function query_gagal() {
echo "<script>alert('query gagal')</script>";
}
function tampilkan_data_tabel($tabel,$parameter="",$link_ke_edit="",$tampil="*"){
$query="select $tampil from $tabel"." ".$parameter;
$hasil_exe=mysql_query($query);
if($hasil_exe){
if(mysql_num_rows($hasil_exe) != 0) {
$hasil='';
$hasil_perbaris='';
$j=1;
while($data=mysql_fetch_array($hasil_exe)){
    if($link_ke_edit ==""){
$batas=ceil(sizeof($data)/2);
}
else $batas=ceil(sizeof($data)/2)+1;
echo "<tr><td>$j</td>";
for($i=0;$i<$batas;$i++){
    if($link_ke_edit !=""){
        if($i==($batas-1)){
    echo "<td><a href=$link_ke_edit?id=$data[0]>edit</a></td>";
    $cetak="";
    }
    else $cetak="<td>".$data[$i]."</td>";
    }
        else $cetak="<td>".$data[$i]."</td>";
        echo $cetak;
}
$j++;
echo "</tr>";
}
}
else echo "Data masih kosong";
}
else {
query_gagal();
}
}
function tampilkan_tabel($sql,$tampil,$pesan,$judul=""){
	$sql_exc = mysql_query($sql);
	//query sukses
	if($sql_exc){
		$jml_baris =mysql_num_rows($sql_exc);
		if($jml_baris > 0){
			//buat dalam bentuk tabel
			$hasil="<table class='listing' cellspacing='0' cellpadding='1' align='center'>
				<caption style='font-size:1em'>$judul</caption>
				<thead>
				<tr>
				<th>No</th>";
			//$jum_kolom =mysql_num_fields($sql_exc);
			for($i = 0; $i < count($tampil); $i++){
			$hasil.= "<th>$tampil[$i]</th>";
				}
			$hasil.= "</thead><tbody>";
			$h = 1;
			while($baris =mysql_fetch_array($sql_exc)){
				$hasil.= "<tr><td>".$h."</td>";
				for($j = 0; $j < count($tampil); $j++){
					$n_k = $tampil[$j];
				$hasil.= "<td>$baris[$n_k]</td>";	
						}
					//	$hasil.= $kolom_link;
				$hasil.= "</tr>";
				$h++;
				}	
			$hasil.= "</tbody>	
			</table>
			";
		}
	else $hasil= $pesan;
}
else $hasil = "Query salah, hubungi admin / pengembang program, please.......". $sql;
return $hasil;
}
?>

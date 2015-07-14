<?php
// menggunakan class phpExcelReader
include "include/excel_reader2.php";
include "include/koneksi.php";
// membaca file excel yang diuploada
//$file = $_FILES['userfile'];
$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
// membaca jumlah baris dari data excel
$baris = $data->rowcount($sheet_index=0);

// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
$sukses = 0;
$gagal = 0;

// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
  // membaca data id (kolom ke-1)
  $nim = $data->val($i, 1);
  // membaca data nama (kolom ke-2)
  $nama = $data->val($i, 2);
  // membaca data alamat (kolom ke-3)
  $alamat = $data->val($i, 3);
  // membaca data alamat (kolom ke-3)
  $agama = $data->val($i, 4);

  // setelah data dibaca, sisipkan ke dalam tabel mhs
  $query = "INSERT INTO siswa VALUES ('$nim', '$nama', '$alamat', '$agama')";
  $hasil = mysql_query($query);
  // jika proses insert data sukses, maka counter $sukses bertambah
  // jika gagal, maka counter $gagal yang bertambah
  if ($hasil) {
	$nim_sukses .="  ". $nim;
  $sukses++;
}
  else {
$nim_gagal .="  ". $nim;	  
	  $gagal++;
	  }
 }

// tampilan status sukses dan gagal
echo "<h3>Proses import data selesai.</h3>";
echo "<div>Jumlah data yang sukses diimport : ".$sukses."<br>";
echo $nim_sukses."</div>";
echo "<div style='background-color:pink'>Jumlah data yang gagal diimport : ".$gagal."<br>";;
echo $nim_gagal;
echo "</div>";
?>

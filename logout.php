<?php
/*--------------------------------------------------------
 halaman untuk logout, hapus session dan redirect ke halaman index.php
 *--------------------------------------------------------*/ 
session_start();
session_destroy();
header("location:index.php");
?>

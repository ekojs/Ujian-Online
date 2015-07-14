<?php 
include_once "include/cek_session.php";
if($_SESSION["level_kj"] != "admin"){
	echo "<div class='peringatan'>hanya untuk admin, area terlarang untuk anda .....<a href='index.php'>Kembali</a></div>";	
	echo "<style>
	.peringatan{
		border:2px solid #FF0000;
		background:#FAC7D0;
		padding:7px;
		}
	
	</style>";
}
else {
?>
<html>
    
    <head>
        <title>Admin | Ujian Online - SMK HIdayatullah Samarinda</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        
        <link href="images/pavicon.png" rel="shortcut icon">
		<link  href="css/calendar.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
		<script src="js/ckeditor.js"></script>
		<script src="js/ckfinder/ckfinder.js"></script>
		<script src="js/config.js"></script>
		<script src="js/ckeditor_fungsi.js"></script>
		<script src="js/calendar.js"></script>
<script >
var info_loading = "<div style='font-size:110%;font-style:italic;font-weight:bolder;width:150px;margin:0 auto;' class='tombol loading'>Sedang proses .............</div>";	
function bersihkan(elm){
	$("#content").data($(elm).attr("name"),$(elm).val());
	$(elm).val("");
	}
function kembali_semula(elm){
	if($(elm).val() == ""){
		$(elm).val($("#content").data($(elm).attr("name")));
		}
	}	
function load_menu(elm){
		$(".menu_terpilih").eq(0).removeClass("menu_terpilih").addClass("menu_awal");
		$(elm).parent().removeClass("menu_awal").addClass("menu_terpilih");
		var url = $(elm).attr("href");
		$("#content").html(info_loading).load(url);
		$("body").data("back_url",url);
		return false;
	}
function kembali_lagi(){
//	alert($("body").data("back_url"));
	$("#content").html(info_loading).load($("body").data("back_url"));
	}		
$(function(){
	$(".menu_awal>a").eq(0).click();
	$("body").data("back_url","beranda.php");
	})		
</script>
    </head>
    
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                           <li>
								<a tabindex="-1" onclick="return load_menu(this)" href="profil.php"><i class="icon-user"></i> Profil</a>
                           </li>
                           <li>
								<a tabindex="-1" onclick="return load_menu(this)" href="ganti_pass.php"><i class="icon-lock"></i> Ganti Password</a>
                           </li>
                           <li>
								<a href="logout.php"><i class="icon-off"></i> Keluar</a>
                           </li>
                        </ul>
                          
                        <ul class="nav">
                            <li class="menu_awal">
								<a onclick="return load_menu(this)" href="beranda.php"><i class="icon-home"></i> Beranda</a>
                            </li>
                            <li>
								<a onclick="return load_menu(this)" href="daftar_mp_kelas.php"> Daftar Ujian</a>
                            </li>
                            <li>
								<a onclick="return load_menu(this)" href="daftar_kelas.php"> Daftar Kelas</a>
                            </li>             
                            <li>
								<a onclick="return load_menu(this)" href="daftar_guru.php"> Daftar Guru</a>
                            </li>
                            <li>
								<a onclick="return load_menu(this)" href="mengajar.php"> Mengajar</a>
                            </li>
                            <li>
								<a onclick="return load_menu(this)" href="daftar_siswa.php"> Daftar Siswa</a>
                            </li>	
                            <li>
								<a onclick="return load_menu(this)" href="daftar_kelas_mp.php"> Lihat Nilai</a>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
				<div id="content"></div>
			</div>
            <hr>
            <footer>
                <p>&copy; 2015 SMK Hidayatullah Samarinda</p>
            </footer>
        </div>
        <!--/.fluid-container-->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/jquery.uniform.min.js"></script>
        <script src="vendors/chosen.jquery.min.js"></script>
        <script src="vendors/bootstrap-datepicker.js"></script>

        <script>
        $(function() {
            // Easy pie charts
            $('.chart').easyPieChart({animate: 1000});
        });
        </script>
    </body>

</html>
<?php
}
?>

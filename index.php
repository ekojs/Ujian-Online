<?php
session_start();
if(isset($_SESSION['login_kj'])){
	header("location:hal_".$_SESSION['level_kj'].".php");	
	}
else {	
?>
<html>
<head>
	<title>Login | Ujian Online - SMK HIdayatullah Samarinda</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<link href="image/kj.png" rel="shortcut icon">
</head>
<body id="login" onload="document.forms[0]['id_user'].focus()">
	<div class="container">
		<?php
		if(isset($_GET['info'])){
			$display = "block";
			$pemberitahuan = $_GET['info'];
			}
		else{
			$display = "none";	
			$pemberitahuan = "";
			}
		?>
	        <div class="alert alert-error" style="display:<?php echo $display ?>"><?php echo $pemberitahuan; ?>
				<button class="close" data-dismiss="alert">&times;</button>
			</div>

		<form class="form-signin" action="login.php" method="post">
	        <h2 class="form-signin-heading"><legend>Halaman Login</legend></h2>
			<input type="text" class="input-block-level" placeholder="NIS atau Username" name="id_user"/>
			<input type="password" class="input-block-level" placeholder="Password" name="password"/>
			<button class="btn btn-primary" type="submit">Login</button>
		</form>
	</div>
	<script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
?>

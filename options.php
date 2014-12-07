<?php session_start(); 
	if($_SESSION['id_korisnika']!=$_GET['user']){
		header("Location:index.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
		include("./inc/head.inc");
	?>
</head>
<body onLoad="online();">
	<div id="container">
		<div id="top">
			<div id="online">
			</div>
			<div id="login_form">
			</div>
		</div>
		<div id="header">
			<?php 
				include("./inc/header.inc");
			?>
		</div>
		<div id="menu">
		</div>
		<div id="center_content">
			<div class="admin_options"><a href="user_settings.php?user=<?php echo $_SESSION['id_korisnika']; ?>">Podešavanja</a></div>
			<div class="admin_options"><a href="statistics.php">Statistika</a></div>
			<div class="admin_options"><a href="profile.php?user=<?php echo $_SESSION['id_korisnika']; ?>">Profil</a></div>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
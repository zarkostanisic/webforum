<?php session_start(); 
	if(!$_SESSION['uloga']=="administrator"){
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
			<div class="admin_title">Administracija</div>
			<div class="admin_options"><a href="admin_categories.php">Kategorije</a></div>
			<div class="admin_options"><a href="admin_subcategories.php">Podkategorije</a></div>
			<div class="admin_options"><a href="admin_themes.php">Teme</a></div>
			<div class="admin_options"><a href="admin_users.php">Korisnici</a></div>
			<div class="admin_options"><a href="admin_settings.php">Podešavanja</a></div>
			<div class="admin_options"><a href="admin_messages.php">Poruke</a></div>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
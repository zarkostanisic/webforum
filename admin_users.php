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
<body onLoad="admin_user_show();">
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
			<?php
				include("./inc/konekcija.inc");
				
				echo "<div class='admin_title'>Izmeni i izbriši korisnike</div>";
				echo "<div class='admin_form'>";
				echo "<table>";
				echo "<form name='dodaj_korisnika'>";
				echo "<td>Korisničko ime:</td>";
				echo "<td><input type='text' id='korisnicko_ime' class='add_input' onKeyUp='admin_user_show(0);'/></td>";
				echo "<td id='query_print'></td>";
				echo "<td id='funkcija'></td>";
				echo "</tr>";
				echo "</form>";
				echo "</table>";
				echo "</div>";
				echo "<div class='admin_title_bottom'></div>";
				echo "<div id='admin_user_print' style='float:left;'></div>";
				
				mysql_close($konekcija);
			?>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
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
<body onLoad="admin_category_show();">
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
				echo "<div class='admin_title'>Dodaj, izmeni i izbriši kategorije</div>";
				echo "<div class='admin_form'>";
				echo "<table>";
				echo "<form name='dodaj_kategoriju'>";
				echo "<tr>";
				echo "<td>Naziv kategorije:</td>";
				echo "<td><input type='text' id='naziv_kategorije' class='add_input'/></td>";
				echo "<td><input type='button' id='dodaj' value=' ' class='add_bt' onClick='add_category();'/></td>";
				echo "<td id='query_print'></td>";
				echo "<td id='funkcija'></td>";
				echo "</tr>";
				echo "</form>";
				echo "</table>";
				echo "</div>";
				echo "<div class='admin_title_bottom'></div>";
				echo "<div id='admin_category_print'></div>";
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
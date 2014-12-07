<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
		include("./inc/head.inc");
	?>
</head>
<body onLoad="show_themes(<?php echo $_GET['subcategory']; ?>);">
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
				$id_podkategorije=$_GET['subcategory'];
				$upit_podkategorije="SELECT * FROM podkategorije WHERE id_podkategorije='".$id_podkategorije."'";
				$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
				if($rezultat_podkategorije){
					$podkategorija=mysql_fetch_array($rezultat_podkategorije);
				}
				echo "<div class='theme_category'><p>".$podkategorija['naziv_podkategorije']."</p></div>";
				if(isset($_SESSION['uloga'])&&$podkategorija['status']=="1"){
					echo "<div class='admin_form' id='admin_form'>";
					echo "<table>";
					echo "<form name='dodaj_temu'>";
					echo "<tr>";
					echo "<td>Pitanje:</td>";
					echo "<td><textarea class='theme_textarea' id='pitanje'></textarea></td>";
					echo "<td>Naziv teme:</td>";
					echo "<td><input type='text' id='naziv_teme' class='add_input'/></td>";
					echo "<td><input type='button' id='dodaj' class='add_bt' onClick='user_add_theme();'/></td>";
					echo "<td><input type='hidden' id='podkategorija' value='".$podkategorija['id_podkategorije']."' /></td>";
					echo "<td id='query_input'></td>";
					echo "<td id='stranicenje'><input type='hidden' id='s' value='0'/></td>";
					echo "<td id='funkcija'></td>";
					echo "</tr>";
					echo "</form>";
					echo "</table>";
					echo "</div>";
				}else{
					echo "<form name='dodaj_temu'>";
					echo "<div><input type='hidden' id='podkategorija' value='".$podkategorija['id_podkategorije']."' /></div>";
					echo "<div id='query_input'></div>";
					echo "<div id='stranicenje'><input type='hidden' id='s' value='0'/></div>";
					echo "<div id='funkcija'></div>";
					echo "</form>";
				}
				mysql_close($konekcija);
			?>
			<div id="show_themes"></div>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
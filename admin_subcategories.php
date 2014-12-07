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
<body onLoad="admin_subcategory_show();">
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
				
				echo "<div class='admin_title'>Dodaj, izmeni i izbriši podkategorije</div>";
				echo "<div class='admin_form'>";
				echo "<table>";
				echo "<form name='dodaj_kategoriju'>";
				echo "<tr>";
				echo "<td>Kategorija:</td>";
				echo "<td>";
				echo "<select id='kategorija' class='add_select' onChange='admin_subcategory_show(0);'>";
				echo "<option value='0'>Izaberi</option>";
	
				$upit_kategorije="SELECT * FROM kategorije";
				$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
				if($rezultat_kategorije){
					$broj=mysql_num_rows($rezultat_kategorije);
					if($broj>0){
						while($kategorija=mysql_fetch_array($rezultat_kategorije)){
							echo "<option value='".$kategorija['id_kategorije']."'>".$kategorija['naziv_kategorije']."</option>";
						}
					}
				}
	
				echo "</select>";
				echo "</td>";
				echo "<td>Naziv podkategorije:</td>";
				echo "<td><input type='text' id='naziv_podkategorije' class='add_input'/></td>";
				echo "<td><input type='button' id='dodaj' value=' ' class='add_bt' onClick='add_subcategory();'/></td>";
				echo "<td id='query_input'></td>";
				echo "<td id='funkcija'></td>";
				echo "</tr>";
				echo "</form>";
				echo "</table>";
				echo "</div>";
				echo "<div class='admin_title_bottom'></div>";
				echo "<div id='admin_subcategory_print'></div>";
				
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
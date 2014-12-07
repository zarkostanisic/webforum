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
			<?php 
				include("./inc/konekcija.inc");
				
				$id_kategorije=$_GET['category'];
				
				$upit_izmena="SELECT * FROM kategorije WHERE id_kategorije='".$id_kategorije."'";
				$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
				if($rezultat_izmena){
					$broj=mysql_num_rows($rezultat_izmena);
					if($broj==1){
						$kategorija=mysql_fetch_array($rezultat_izmena);
						echo "<div class='admin_title'>Izmeni kategoriju ".$kategorija['naziv_kategorije']."</div>";
						echo "<div class='admin_form'>";
						echo "<form name='izmena_kategorije'>";
						echo "<table>";
						echo "<tr>";
						echo "<td>Naziv kategorije:</td>";
						echo "<td><input type='text' id='naziv_kategorije' value='".$kategorija['naziv_kategorije']."' class='add_input'/></td>";
						echo "<td><input type='hidden' id='id_kategorije' value='".$kategorija['id_kategorije']."'/></td>";
						echo "<td><input type='button' value=' ' onClick='change_category();' class='change_bt'/></td>";
						echo "</tr>";
						echo "</table>";
						echo "</form>";
						echo "</div>";
					}
				}
				
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
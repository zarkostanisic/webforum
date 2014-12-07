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
				
				$id_podkategorije=$_GET['subcategory'];
				
				$upit_izmena="SELECT * FROM podkategorije WHERE id_podkategorije='".$id_podkategorije."'";
				$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
				if($rezultat_izmena){
					$broj=mysql_num_rows($rezultat_izmena);
					if($broj==1){
						$podkategorija=mysql_fetch_array($rezultat_izmena);
						echo "<div class='admin_title'>Izmeni podkategoriju ".$podkategorija['naziv_podkategorije']."</div>";
						echo "<div class='admin_form'>";
						echo "<form name='izmena_kategorije'>";
						echo "<table>";
						echo "<tr>";
						echo "<td>Kategorija:</td>";
						echo "<td>";
						echo "<select id='kategorija' class='add_select'";
						echo "<option value='0'>Izaberi</option>";
	
						$upit_kategorije="SELECT * FROM kategorije";
						$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
						if($rezultat_kategorije){
							$broj=mysql_num_rows($rezultat_kategorije);
							if($broj>0){
								while($kategorija=mysql_fetch_array($rezultat_kategorije)){
									if($podkategorija['id_kategorije']==$kategorija['id_kategorije']){
										echo "<option value='".$kategorija['id_kategorije']."' selected>".$kategorija['naziv_kategorije']."</option>";
									}else{
										echo "<option value='".$kategorija['id_kategorije']."'>".$kategorija['naziv_kategorije']."</option>";
									}
								}
							}
						}
						echo "</select>";
						echo "</td>";
						echo "<td>Naziv podkategorije:</td>";
						echo "<td><input type='text' id='naziv_podkategorije' value='".$podkategorija['naziv_podkategorije']."' class='add_input'/></td>";
						echo "<td><input type='hidden' id='id_podkategorije' value='".$podkategorija['id_podkategorije']."'/></td>";
						echo "<td><input type='button' value=' ' onClick='change_subcategory();' class='change_bt'/></td>";
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
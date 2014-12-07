<?php 
	include("../inc/konekcija.inc");
	
	$id_podkategorije=$_GET['subcategory_id'];
	$naziv_podkategorije=$_GET['subcategory_name'];
	$id_kategorije=$_GET['category_id'];
	$upit_izmena="UPDATE podkategorije SET naziv_podkategorije='".$naziv_podkategorije."',id_kategorije='".$id_kategorije."' WHERE id_podkategorije='".$id_podkategorije."'";
	$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
	if($rezultat_izmena){
		$upit_podkategorije="SELECT * FROM podkategorije WHERE id_podkategorije='".$id_podkategorije."'";
		$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
		if($rezultat_podkategorije){
			$broj=mysql_num_rows($rezultat_podkategorije);
			if($broj==1){
				$podkategorija=mysql_fetch_array($rezultat_podkategorije);
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
				echo "<td><input type='button' value='' onClick='change_subcategory();' class='change_bt'/></td>";
				echo "<td>Uspešno</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				echo "</div>";
			}
		}
	}else{
		$upit_podkategorije="SELECT * FROM podkategorije WHERE id_podkategorije='".$id_podkategorije."'";
		$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
		if($rezultat_podkategorije){
			$broj=mysql_num_rows($rezultat_podkategorije);
			if($broj==1){
				$podkategorija=mysql_fetch_array($rezultat_podkategorije);
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
				echo "<td><input type='button' value='' onClick='change_subcategory();' class='change_bt'/></td>";
				echo "<td>Greška</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				echo "</div>";
			}
		}
	}
	
	mysql_close($konekcija);
?>
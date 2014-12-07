<?php 
	include("../inc/konekcija.inc");
	
	$id_teme=$_POST['theme_id'];
	$naziv_teme=$_POST['theme_name'];
	$id_podkategorije=$_POST['subcategory_id'];
	$pitanje=$_POST['question'];
	
	$upit_izmena="UPDATE teme SET naziv_teme='".$naziv_teme."',id_podkategorije='".$id_podkategorije."',pitanje='".$pitanje."' WHERE id_teme='".$id_teme."'";
	$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
	if($rezultat_izmena){
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE id_teme='".$id_teme."'";
		$rezultat_teme=mysql_query($upit_teme,$konekcija);
		if($rezultat_teme){
			$broj=mysql_num_rows($rezultat_teme);
			if($broj==1){
				$tema=mysql_fetch_array($rezultat_teme);
				echo "<div class='admin_title'>Izmeni temu ".$tema['naziv_teme']."</div>";
				echo "<div class='admin_form'>";
				echo "<form name='izmena_kategorije'>";
				echo "<table>";
				echo "<tr>";
				echo "<td>Pitanje:</td>";
				echo "<td colspan='7'><textarea class='admin_textarea' id='pitanje'>".$tema['pitanje']."</textarea></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>Kategorija:</td>";
				echo "<td>";
				echo "<select id='kategorija' class='add_select' onChange='admin_theme_change_select();'";
				echo "<option value='0'>Izaberi</option>";
	
				$upit_kategorije="SELECT * FROM kategorije";
				$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
				if($rezultat_kategorije){
					$broj=mysql_num_rows($rezultat_kategorije);
					if($broj>0){
						while($kategorija=mysql_fetch_array($rezultat_kategorije)){
							if($tema['id_kategorije']==$kategorija['id_kategorije']){
								echo "<option value='".$kategorija['id_kategorije']."' selected>".$kategorija['naziv_kategorije']."</option>";
							}else{
								echo "<option value='".$kategorija['id_kategorije']."'>".$kategorija['naziv_kategorije']."</option>";
							}
						}
					}
				}
				echo "</select>";
				echo "</td>";
				echo "<td>Podkategorija:</td>";
				echo "<td id='admin_the_change_select'>";
				echo "<select id='podkategorija' class='add_select'";
				echo "<option value='0'>Izaberi</option>";
	
				$upit_podkategorije="SELECT * FROM podkategorije p JOIN kategorije k ON p.id_kategorije=k.id_kategorije WHERE p.id_kategorije='".$tema['id_kategorije']."'";
				$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
				if($rezultat_podkategorije){
					$broj=mysql_num_rows($rezultat_podkategorije);
					if($broj>0){
						while($podkategorija=mysql_fetch_array($rezultat_podkategorije)){
							if($tema['id_podkategorije']==$podkategorija['id_podkategorije']){
								echo "<option value='".$podkategorija['id_podkategorije']."' selected>".$podkategorija['naziv_podkategorije']."</option>";
							}else{
								echo "<option value='".$podkategorija['id_podkategorije']."'>".$podkategorija['naziv_podkategorije']."</option>";
							}
						}
					}
				}
				echo "</select>";
				echo "</td>";
				echo "<td>Naziv teme:</td>";
				echo "<td><input type='text' id='naziv_teme' value='".$tema['naziv_teme']."' class='add_input'/></td>";
				echo "<td><input type='hidden' id='id_teme' value='".$tema['id_teme']."'/></td>";
				echo "<td><input type='button' value=' ' onClick='change_theme();' class='change_bt'/></td>";
				echo "<td>Uspešno</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				echo "</div>";
			}
		}
	}else{
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE id_teme='".$id_teme."'";
		$rezultat_teme=mysql_query($upit_teme,$konekcija);
		if($rezultat_teme){
			$broj=mysql_num_rows($rezultat_teme);
			if($broj==1){
				$tema=mysql_fetch_array($rezultat_teme);
				echo "<div class='admin_title'>Izmeni kategoriju ".$tema['naziv_teme']."</div>";
				echo "<div class='admin_form'>";
				echo "<form name='izmena_kategorije'>";
				echo "<table>";
				echo "<tr>";
				echo "<td>Pitanje:</td>";
				echo "<td colspan='7'><textarea class='admin_textarea' id='pitanje'>".$tema['pitanje']."</textarea></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>Kategorija:</td>";
				echo "<td>";
				echo "<select id='kategorija' class='add_select' onChange='admin_theme_change_select();'";
				echo "<option value='0'>Izaberi</option>";
	
				$upit_kategorije="SELECT * FROM kategorije";
				$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
				if($rezultat_kategorije){
					$broj=mysql_num_rows($rezultat_kategorije);
					if($broj>0){
						while($kategorija=mysql_fetch_array($rezultat_kategorije)){
							if($tema['id_kategorije']==$kategorija['id_kategorije']){
								echo "<option value='".$kategorija['id_kategorije']."' selected>".$kategorija['naziv_kategorije']."</option>";
							}else{
								echo "<option value='".$kategorija['id_kategorije']."'>".$kategorija['naziv_kategorije']."</option>";
							}
						}
					}
				}
				echo "</select>";
				echo "</td>";
				echo "<td>Podkategorija:</td>";
				echo "<td id='admin_the_change_select'>";
				echo "<select id='podkategorija' class='add_select'";
				echo "<option value='0'>Izaberi</option>";
	
				$upit_podkategorije="SELECT * FROM podkategorije p JOIN kategorije k ON p.id_kategorije=k.id_kategorije WHERE p.id_kategorije='".$tema['id_kategorije']."'";
				$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
				if($rezultat_podkategorije){
					$broj=mysql_num_rows($rezultat_podkategorije);
					if($broj>0){
						while($podkategorija=mysql_fetch_array($rezultat_podkategorije)){
							if($tema['id_podkategorije']==$podkategorija['id_podkategorije']){
								echo "<option value='".$podkategorija['id_podkategorije']."' selected>".$podkategorija['naziv_podkategorije']."</option>";
							}else{
								echo "<option value='".$podkategorija['id_podkategorije']."'>".$podkategorija['naziv_podkategorije']."</option>";
							}
						}
					}
				}
				echo "</select>";
				echo "</td>";
				echo "<td>Naziv teme:</td>";
				echo "<td><input type='text' id='naziv_teme' value='".$tema['naziv_teme']."' class='add_input'/></td>";
				echo "<td><input type='hidden' id='id_teme' value='".$tema['id_teme']."'/></td>";
				echo "<td><input type='button' value=' ' onClick='change_theme();' class='change_bt'/></td>";
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
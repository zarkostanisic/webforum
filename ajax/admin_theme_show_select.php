<?php
	include("../inc/konekcija.inc");
	$id_kategorije=$_GET['category_id'];
	if($id_kategorije!=0){
		echo "<table>";
		echo "<form name='dodaj_temu'>";
		echo "<tr>";
		echo "<td>Pitanje:</td>";
		echo "<td colspan='9'><textarea class='admin_textarea' id='pitanje'></textarea></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Kategorija:</td>";
		echo "<td>";
		echo "<select id='kategorija' class='add_select' onChange='admin_theme_show_select(0);'>";
		echo "<option value='0'>Izaberi</option>";
	
		$upit_kategorije="SELECT * FROM kategorije";
		$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
		if($rezultat_kategorije){
			$broj=mysql_num_rows($rezultat_kategorije);
			if($broj>0){
				while($kategorija=mysql_fetch_array($rezultat_kategorije)){
					if($kategorija['id_kategorije']==$id_kategorije){
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
		echo "<td>";
		echo "<select id='podkategorija' class='add_select' onChange='admin_theme_show(0);'>";
		echo "<option value='0'>Izaberi</option>";
	
		$upit_podkategorije="SELECT * FROM podkategorije WHERE id_kategorije='".$id_kategorije."'";
		$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
		if($rezultat_podkategorije){
			$broj=mysql_num_rows($rezultat_podkategorije);
			if($broj>0){
				while($podkategorija=mysql_fetch_array($rezultat_podkategorije)){
					echo "<option value='".$podkategorija['id_podkategorije']."'>".$podkategorija['naziv_podkategorije']."</option>";
				}
			}
		}
		echo "</select>";
		echo "</td>";
		echo "<td>Naziv teme:</td>";
		echo "<td><input type='text' id='naziv_teme' class='add_input'/></td>";
		echo "<td><input type='button' id='dodaj' value=' ' class='add_bt' onClick='add_theme();'/></td>";
		echo "<td id='query_input'></td>";
		echo "<td id='funkcija'></td>";
		echo "</tr>";
		echo "</form>";
		echo "</table>";
	}else{
		echo "<table>";
		echo "<form name='dodaj_temu'>";
		echo "<tr>";
		echo "<td>Kategorija:</td>";
		echo "<td>";
		echo "<select id='kategorija' class='add_select' onChange='admin_theme_show_select(0);'>";
		echo "<option value='0'>Izaberi</option>";
	
		$upit_kategorije="SELECT * FROM kategorije";
		$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
		if($rezultat_kategorije){
			$broj=mysql_num_rows($rezultat_kategorije);
			if($broj>0){
				while($kategorija=mysql_fetch_array($rezultat_kategorije)){
					if($kategorija['id_kategorije']==$id_kategorije){
						echo "<option value='".$kategorija['id_kategorije']."' selected>".$kategorija['naziv_kategorije']."</option>";
					}else{
						echo "<option value='".$kategorija['id_kategorije']."'>".$kategorija['naziv_kategorije']."</option>";
					}
				}
			}
		}
	
	
		echo "</select>";
		echo "</td>";
		echo "<td id='query_input'></td>";
		echo "<td id='funkcija'></td>";
		echo "</tr>";
		echo "</form>";
		echo "</table>";
	}
	
	mysql_close($konekcija);
?>
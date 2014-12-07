<?php 
	include("../inc/konekcija.inc");
	
	$id_kategorije=$_GET['category_id'];
	$naziv_kategorije=$_GET['category_name'];
	$upit_izmena="UPDATE kategorije SET naziv_kategorije='".$naziv_kategorije."' WHERE id_kategorije='".$id_kategorije."'";
	$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
	if($rezultat_izmena){
		$upit_kategorije="SELECT * FROM kategorije WHERE id_kategorije='".$id_kategorije."'";
		$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
		if($rezultat_kategorije){
			$broj=mysql_num_rows($rezultat_kategorije);
			if($broj==1){
				$kategorija=mysql_fetch_array($rezultat_kategorije);
				echo "<div class='admin_title'>Izmeni kategoriju ".$kategorija['naziv_kategorije']."</div>";
				echo "<div class='admin_form'>";
				echo "<form name='izmena_kategorije'>";
				echo "<table>";
				echo "<tr>";
				echo "<td>Naziv kategorije:</td>";
				echo "<td><input type='text' id='naziv_kategorije' value='".$kategorija['naziv_kategorije']."' class='add_input'/></td>";
				echo "<td><input type='hidden' id='id_kategorije' value='".$kategorija['id_kategorije']."'/></td>";
				echo "<td><input type='button' value='' onClick='change_category();' class='change_bt'/></td>";
				echo "<td>Uspešno</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				echo "</div>";
			}
		}
	}else{
		$upit_kategorije="SELECT * FROM kategorije WHERE id_kategorije='".$id_kategorije."'";
		$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
		if($rezultat_kategorije){
			$broj=mysql_num_rows($rezultat_kategorije);
			if($broj==1){
				$kategorija=mysql_fetch_array($rezultat_kategorije);
				echo "<div class='admin_title'>Izmeni kategoriju ".$kategorija['naziv_kategorije']."</div>";
				echo "<div class='admin_form'>";
				echo "<form name='izmena_kategorije'>";
				echo "<table>";
				echo "<tr>";
				echo "<td>Naziv kategorije:</td>";
				echo "<td><input type='text' id='naziv_kategorije' value='".$kategorija['naziv_kategorije']."' class='add_input'/></td>";
				echo "<td><input type='hidden' id='id_kategorije' value='".$kategorija['id_kategorije']."'/></td>";
				echo "<td><input type='button' value='' onClick='change_category();' class='change_bt'/></td>";
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
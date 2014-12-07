<?php
	include("../inc/konekcija.inc");
	
	$id_kategorije=$_GET['category_id'];
	if($id_kategorije!=0){
		echo "<select id='podkategorija' class='add_select' onChange='admin_theme_show();>";
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
	}
	
	mysql_close($konekcija);
?>
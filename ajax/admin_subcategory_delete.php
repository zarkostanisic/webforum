<?php 
	include("../inc/konekcija.inc");
	
	$podkategorija=$_GET['subcategory'];
	
	$upit_brisanje="DELETE FROM podkategorije WHERE id_podkategorije='".$podkategorija."'";
	$rezultat_brisanje=mysql_query($upit_brisanje,$konekcija);
	if($rezultat_brisanje){
		$upit_teme="SELECT * FROM teme WHERE id_podkategorije='".$podkategorija."'";
		$rezultat_teme=mysql_query($upit_teme,$konekcija);
		if($rezultat_teme){
			$broj=mysql_num_rows($rezultat_teme);
			if($broj>0){
				while($tema=mysql_fetch_array($rezultat_teme)){
					$upit_brisanje_postova="DELETE FROM postovi WHERE id_teme='".$tema['id_teme']."'";
					$rezultat_brisanje_postova=mysql_query($upit_brisanje_postova,$konekcija);
				}
			}
		}
		$upit_brisanje_tema="DELETE FROM teme WHERE id_podkategorije='".$podkategorija."'";
		$rezultat_brisanje_tema=mysql_query($upit_brisanje_tema,$konekcija);
	}
	
	mysql_close($konekcija);
?>
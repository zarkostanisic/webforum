<?php 
	include("../inc/konekcija.inc");
	
	$kategorija=$_GET['category'];
	$upit_brisanje="DELETE FROM kategorije WHERE id_kategorije='".$kategorija."'";
	$rezultat_brisanje=mysql_query($upit_brisanje,$konekcija);
	if($rezultat_brisanje){
		$upit_podkategorije="SELECT * FROM podkategorije WHERE id_kategorije='".$kategorija."'";
		$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
		if($rezultat_podkategorije){
			$broj=mysql_num_rows($rezultat_podkategorije);
			if($broj>0){
				while($podkategorija=mysql_fetch_array($rezultat_podkategorije)){
					$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_podkategorije='".$podkategorija['id_podkategorije']."'";
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
					$upit_brisanje_tema="DELETE FROM teme WHERE id_podkategorije='".$podkategorija['id_podkategorije']."'";
					$rezultat_brisanje_tema=mysql_query($upit_brisanje_tema,$konekcija);
				}
				$upit_brisanje_podkategorija="DELETE FROM podkategorije WHERE id_kategorije='".$kategorija."'";
				$rezultat_brisanje_podkategorija=mysql_query($upit_brisanje_podkategorija,$konekcija);
			}
		}
	}
	
	mysql_close($konekcija);
?>
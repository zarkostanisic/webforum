<?php 
	include("../inc/konekcija.inc");
	$id_podkategorije=$_GET['subcategory_id'];
	$status=$_GET['status'];
	
	$upit_zatvori_podkategoriju="UPDATE podkategorije SET status='".$status."' WHERE id_podkategorije='".$id_podkategorije."'";
	$rezultat_zatvori_podkategoriju=mysql_query($upit_zatvori_podkategoriju,$konekcija);
	if($rezultat_zatvori_podkategoriju){
		$upit_zatvori_teme="UPDATE teme SET status='".$status."' WHERE id_podkategorije='".$id_podkategorije."'";
		$rezultat_zatvori_teme=mysql_query($upit_zatvori_teme,$konekcija);
	}
	mysql_close($konekcija);
?>
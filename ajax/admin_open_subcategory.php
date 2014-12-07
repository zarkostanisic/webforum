<?php 
	include("../inc/konekcija.inc");
	$id_podkategorije=$_GET['subcategory_id'];
	$status=$_GET['status'];
	
	$upit_otvori_podkategoriju="UPDATE podkategorije SET status='".$status."' WHERE id_podkategorije='".$id_podkategorije."'";
	$rezultat_otvori_podkategoriju=mysql_query($upit_otvori_podkategoriju,$konekcija);
	if($rezultat_otvori_podkategoriju){
		$upit_otvori_teme="UPDATE teme SET status='".$status."' WHERE id_podkategorije='".$id_podkategorije."'";
		$rezultat_otvori_teme=mysql_query($upit_otvori_teme,$konekcija);
	}
	mysql_close($konekcija);
?>
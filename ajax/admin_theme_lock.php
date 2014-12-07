<?php 
	include("../inc/konekcija.inc");
	$id_teme=$_GET['theme_id'];
	$status=$_GET['status'];
	
	$upit_zatvori_temu="UPDATE teme SET status='".$status."' WHERE id_teme='".$id_teme."'";
	$rezultat_zatvori_temu=mysql_query($upit_zatvori_temu,$konekcija);
	
	mysql_close($konekcija);
?>
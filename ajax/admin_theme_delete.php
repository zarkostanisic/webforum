<?php 
	include("../inc/konekcija.inc");
	
	$tema=$_GET['thema'];
	$upit_brisanje="DELETE FROM teme WHERE id_teme='".$tema."'";
	$rezultat_brisanje=mysql_query($upit_brisanje,$konekcija);
	if($rezultat_brisanje){
		$upit_brisanje_postova="DELETE FROM postovi WHERE id_teme='".$tema."'";
		$rezultat_brisanje_postova=mysql_query($upit_brisanje_postova,$konekcija);
	}
	
	mysql_close($konekcija);
?>
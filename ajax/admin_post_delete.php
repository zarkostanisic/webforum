<?php 
	include("../inc/konekcija.inc");
	
	$post=$_GET['post'];
	$upit_brisanje="DELETE FROM postovi WHERE id_posta='".$post."'";
	$rezultat_brisanje=mysql_query($upit_brisanje,$konekcija);
	
	mysql_close($konekcija);
?>
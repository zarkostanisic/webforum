<?php 
	include("../inc/konekcija.inc");
	
	$poruka=$_GET['message'];
	$upit_brisanje="DELETE FROM pisma WHERE id_pisma='".$poruka."'";
	$rezultat_brisanje=mysql_query($upit_brisanje,$konekcija);
	if($rezultat_brisanje){
		echo "uspesno";
	}
	
	mysql_close($konekcija);
?>
<?php 
	include("../inc/konekcija.inc");
	
	$korisnik=$_GET['user'];
	echo $korisnik;
	$upit_brisanje="DELETE FROM pisma WHERE id_posiljaoca='".$korisnik."'";
	$rezultat_brisanje=mysql_query($upit_brisanje,$konekcija);
	if($rezultat_brisanje){
		echo "uspesno";
	}
	
	mysql_close($konekcija);
?>
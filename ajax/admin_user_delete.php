<?php 
	include("../inc/konekcija.inc");
	
	$korisnik=$_GET['user'];
	$upit_brisanje="DELETE FROM korisnici WHERE id_korisnika='".$korisnik."'";
	$rezultat_brisanje=mysql_query($upit_brisanje,$konekcija);
	if($rezultat_brisanje){
		echo "uspesno";
	}
	
	mysql_close($konekcija);
?>
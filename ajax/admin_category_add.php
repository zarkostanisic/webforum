<?php 
	include("../inc/konekcija.inc");
	
	$naziv_kategorije=$_GET['name_category'];
	$upit_dodavanje="INSERT INTO kategorije VALUES('','".$naziv_kategorije."','1')";
	$rezultat_dodavanje=mysql_query($upit_dodavanje,$konekcija);
	
	if($rezultat_dodavanje){
		echo "Uspešno";
	}else{
		echo "Greška";
	}
	
	mysql_close($konekcija);
?>
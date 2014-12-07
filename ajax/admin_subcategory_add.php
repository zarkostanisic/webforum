<?php 
	include("../inc/konekcija.inc");
	
	$naziv_podkategorije=$_GET['subcategory_name'];
	$id_kategorije=$_GET['category_id'];
	
	$upit_dodavanje="INSERT INTO podkategorije VALUES('','".$id_kategorije."','".$naziv_podkategorije."','1')";
	$rezultat_dodavanje=mysql_query($upit_dodavanje,$konekcija);
	
	if($rezultat_dodavanje){
		echo "Uspešno";
	}else{
		echo "Greška";
	}
	
	mysql_close($konekcija);
?>
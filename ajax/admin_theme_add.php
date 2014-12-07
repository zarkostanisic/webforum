<?php session_start();
	include("../inc/konekcija.inc");
	
	$naziv_teme=$_POST['theme_name'];
	$pitanje=$_POST['question'];
	$id_podkategorije=$_POST['subcategory_id'];
	$datum=date("Y-m-d H:i:s");
	if(!isset($_SESSION['uloga'])){
		echo "Niste ulogovani";
	}else{
		$id_korisnika=$_SESSION['id_korisnika'];
		$upit_dodavanje="INSERT INTO teme VALUES('','".$id_podkategorije."','".$id_korisnika."','".$naziv_teme."','".$pitanje."','1','".$datum."')";
		$rezultat_dodavanje=mysql_query($upit_dodavanje,$konekcija);
	
		if($rezultat_dodavanje){
			echo "Uspešno";
		}else{
			echo "Greška";
		}
	}
	
	mysql_close($konekcija);
?>
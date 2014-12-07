<?php session_start();
	include("../inc/konekcija.inc");
	
	$post=$_POST['post'];
	$id_teme=$_POST['theme_id'];
	$datum=date("Y-m-d H:i:s");
	if(!isset($_SESSION['uloga'])){
		echo "Niste ulogovani";
	}else{
		$id_korisnika=$_SESSION['id_korisnika'];
		$upit_dodavanje="INSERT INTO postovi VALUES('','".$id_teme."','".$id_korisnika."','".$post."','".$datum."')";
		$rezultat_dodavanje=mysql_query($upit_dodavanje,$konekcija);
	
		if($rezultat_dodavanje){
			echo "Uspešno";
		}else{
			echo "Greška";
		}
	}
	
	mysql_close($konekcija);
?>
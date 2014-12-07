<?php 
	session_start();
	include("./inc/konekcija.inc");
	$upit_logout="UPDATE online SET status='ne' WHERE id_korisnika='".$_SESSION['id_korisnika']."' AND status='da'";
	$rezultat_logout=mysql_query($upit_logout,$konekcija);
	mysql_close($konekcija);
	unset($_SESSION['uloga']);
	session_destroy();
	header("Location:index.php");
	
?>
<?php	session_start();
	/*prikaz forme za logovanje ako korisnik nije ulogovan*/
	include("../inc/konekcija.inc");
	$upit_podesavanja="SELECT * FROM podesavanja WHERE id_podesavanja='1'";
	$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
	if($rezultat_podesavanja){
		$broj=mysql_num_rows($rezultat_podesavanja);
		if($broj==1){
			$podesavanje=mysql_fetch_array($rezultat_podesavanja);
		}
	}
	if(!isset($_SESSION['uloga'])&&$podesavanje['logovanje']=="1"){
		echo "<form name='logovanje'>";
		echo "<ul>";
		echo "<li>Korisnik:</li>";
		echo "<li><input type='text' id='korisnicko_ime' class='login_input'/></li>";
		echo "<li>Šifra:</li>";
		echo "<li><input type='password' id='sifra' class='login_input'/></li>";
		echo "<li><input type='button' class='login_bt' value=' ' onClick='login();'/></li>";
		echo "</ul>";
		echo "</form>";
	}else if(isset($_SESSION['uloga'])){
		echo "Ulogovani ste kao "."<a href='profile.php?user=".@$_SESSION['id_korisnika']."' class='user'>".@$_SESSION['korisnicko_ime']."</a>, <a href='logout.php' class='logout'>izloguj se</a>";
	}
	mysql_close($konekcija);
?>
<?php session_start();?>
<ul>
	<li><a href="index.php">Početna</a></li>
	<?php 
		if(!isset($_SESSION['uloga'])){
			include("../inc/konekcija.inc");
			$upit_podesavanja="SELECT * FROM podesavanja WHERE id_podesavanja='1'";
			$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
			if($rezultat_podesavanja){
				$broj=mysql_num_rows($rezultat_podesavanja);
				if($broj==1){
					$podesavanje=mysql_fetch_array($rezultat_podesavanja);
				}
			}
			mysql_close($konekcija);
			if($podesavanje['registracija']=="1"){
			echo "<li><a href='registration.php'>Registracija</a></li>";
			}
			echo "<li><a href='contact.php'>Kontakt</a></li>";
		}else{
			if($_SESSION['uloga']=="administrator"){
				echo "<li><a href='administration.php'>Administracija</a></li>";
			}
			echo "<li><a href='inbox.php?user=".$_SESSION['id_korisnika']."'>Pošta</a></li>";
			echo "<li><a href='options.php?user=".$_SESSION['id_korisnika']."'>Opcije</a></li>";
			include("../inc/konekcija.inc");
			$upit_pisma="SELECT * FROM pisma WHERE id_primaoca='".$_SESSION['id_korisnika']."' AND status='1'";
			$rezultat_pisma=mysql_query($upit_pisma,$konekcija);
			if($rezultat_pisma){
				$broj=mysql_num_rows($rezultat_pisma);
				if($broj>0){
					echo "<li><a href='new_messages.php?user=".$_SESSION['id_korisnika']."'>Pisma(".$broj.")</a></li>";
				}
			}
			mysql_close($konekcija);
		}
	?>
	<li><a href="galery.php">Galerija</a></li>
</ul>
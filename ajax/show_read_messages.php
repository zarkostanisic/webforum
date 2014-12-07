 <?php session_start();
	include("../inc/konekcija.inc");
	
	$upit_podesavanja="SELECT * FROM podesavanja WHERE id_korisnika='".@$_SESSION['id_korisnika']."'";
	$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
	if($rezultat_podesavanja){
		$broj_podesavanja=mysql_num_rows($rezultat_podesavanja);
		if($broj_podesavanja==1){
			$podesavanje=mysql_fetch_array($rezultat_podesavanja);
			$broj_po_strani=$podesavanje['broj_pisama'];
		}else{
			$upit_podesavanja="SELECT * FROM podesavanja WHERE id_podesavanja='1'";
			$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
			if($rezultat_podesavanja){
				$broj_podesavanja=mysql_num_rows($rezultat_podesavanja);
				if($broj_podesavanja==1){
					$podesavanje=mysql_fetch_array($rezultat_podesavanja);
					$broj_po_strani=$podesavanje['broj_pisama'];
				}
			}
		}
	}
	
	if(isset($_GET['s'])){
		$s=$_GET['s'];
	}else{
		$s=0;
	}
	
	$right=$s+$broj_po_strani;
	$left=$s-$broj_po_strani;
	$korisnik=$_GET['user'];
	
	$upit_pisma="SELECT * FROM pisma p JOIN korisnici k ON p.id_posiljaoca=k.id_korisnika WHERE p.id_primaoca='".$korisnik."' AND p.status='2' ORDER BY p.id_pisma";
	$rezultat_pisma=mysql_query($upit_pisma,$konekcija);
	if($rezultat_pisma){
		$broj_pisama=mysql_num_rows($rezultat_pisma);
	}
	
	$upit_pisma="SELECT * FROM pisma p JOIN korisnici k ON p.id_posiljaoca=k.id_korisnika WHERE p.id_primaoca='".$korisnik."' AND p.status='2' ORDER BY p.id_pisma DESC LIMIT $broj_po_strani OFFSET $s";
	$rezultat_pisma=mysql_query($upit_pisma,$konekcija);
	if($rezultat_pisma){
		$broj=mysql_num_rows($rezultat_pisma);
		if($broj==0&&$s!=0){
			$s-=$broj_po_strani;
		}
	}
	
	$upit_pisma="SELECT * FROM pisma p JOIN korisnici k ON p.id_posiljaoca=k.id_korisnika WHERE p.id_primaoca='".$korisnik."' AND p.status='2' ORDER BY p.id_pisma DESC LIMIT $broj_po_strani OFFSET $s";
	$rezultat_pisma=mysql_query($upit_pisma,$konekcija);
	if($rezultat_pisma){
		$broj=mysql_num_rows($rezultat_pisma);
		echo "<div class='admin_title'>Pročitane poruke</div>";
		if($broj>0){
			while($pismo=mysql_fetch_array($rezultat_pisma)){
				echo "<div class='message'>";
				echo "<div class='message_top'>Od: <a href='profile.php?user=".$pismo['id_posiljaoca']."'>".$pismo['korisnicko_ime']."</a><input type='button' id='".$pismo['id_pisma']."' onClick='delete_message(this);' class='delete' style='margin-top:0px;'/></div>";
				echo "<div class='message_center'><a href='show_read_message.php?message=".$pismo['id_pisma']."&user=".$pismo['id_primaoca']."'>";
				if(strlen($pismo['pismo'])>30){
					echo substr($pismo['pismo'],0,30).". . ."; 
				}else{
					echo $pismo['pismo'];
				}
				echo "</a></div>";
				echo "<div class='message_bottom'>Vreme: ".$pismo['datum_slanja']."</div>";
				echo "</div>";
			}
			echo "<div class='pagging'>";
			echo "<form name='stranicenje'>";
	
			if($broj_pisama<=$broj_po_strani){
				echo "<div id='funkcija'><input type='hidden' id='izvrsi' value='show_read_messages'/></div>";
				echo "<div><input type='hidden' id='korisnik' value='".$korisnik."'/></div>";
			}else if($left<0){
				echo "<input type='button' id='napred' value='' onclick='next(".'"show_read_messages"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
				echo "<div id='funkcija'><input type='hidden' id='izvrsi' value='show_read_messages'/></div>";
				echo "<div><input type='hidden' id='korisnik' value='".$korisnik."'/></div>";
			}else if($left>=0&&$right<$broj_pisama){
				echo "<input type='button' id='napred' value='' onClick='next(".'"show_read_messages"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"show_read_messages"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
				echo "<div id='funkcija'><input type='hidden' id='izvrsi' value='show_read_messages'/></div>";
				echo "<div><input type='hidden' id='korisnik' value='".$korisnik."'/></div>";
			}else if($right>=$broj_pisama){
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"show_read_messages"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
				echo "<div id='funkcija'><input type='hidden' id='izvrsi' value='show_read_messages'/></div>";
				echo "<div><input type='hidden' id='korisnik' value='".$korisnik."'/></div>";
			}
	
			echo "</form>";
			echo "</div>";
		}else{
			echo "<div class='admin_title'>Nema poruka</div>";
		}
	}
	mysql_close($konekcija);
?>
<?php 
	include("../inc/konekcija.inc");
	
	if(isset($_GET['s'])){
		$s=$_GET['s'];
	}else{
		$s=0;
	}
	$korisnicko_ime=strtolower($_GET['username']);
	$broj_po_strani=12;
	$right=$s+$broj_po_strani;
	$left=$s-$broj_po_strani;
	
	$upit_korisnici="SELECT * FROM korisnici WHERE korisnicko_ime LIKE '".$korisnicko_ime."%'";
	$rezultat_korisnici=mysql_query($upit_korisnici,$konekcija);
	if($rezultat_korisnici){
		$broj_korisnika=mysql_num_rows($rezultat_korisnici);
	}
	
	$upit_korisnici="SELECT * FROM korisnici WHERE korisnicko_ime LIKE '".$korisnicko_ime."%' LIMIT $broj_po_strani OFFSET $s";
	$rezultat_korisnici=mysql_query($upit_korisnici,$konekcija);
	if($rezultat_korisnici){
		$broj=mysql_num_rows($rezultat_korisnici);
		if($broj==0&&$s!=0){
			$s-=$broj_po_strani;
		}
	}
	
	$upit_korisnici="SELECT DISTINCT k.korisnicko_ime,k.id_korisnika FROM korisnici k JOIN pisma p ON k.id_korisnika=p.id_posiljaoca WHERE korisnicko_ime LIKE '".$korisnicko_ime."%' ORDER BY k.korisnicko_ime LIMIT $broj_po_strani OFFSET $s";
	$rezultat_korisnici=mysql_query($upit_korisnici,$konekcija);
	if($rezultat_korisnici){
		$broj=mysql_num_rows($rezultat_korisnici);
		if($broj>0){
			while($korisnik=mysql_fetch_array($rezultat_korisnici)){
				echo "<div class='admin_user'>";
				echo "<div class='admin_user_top'><input type='button' id='".$korisnik['id_korisnika']."' onClick='admin_message_delete(this);' class='delete'/></div>";
				echo "<div class='admin_user_center'><a href='inbox.php?user=".$korisnik['id_korisnika']."'>".$korisnik['korisnicko_ime']."<a/></div>";
				echo "<div class='admin_user_bottom'></div>";
				echo "</div>";
			}
			echo "<div class='pagging'>";
			echo "<form name='stranicenje'>";
	
			if($broj_korisnika<=$broj_po_strani){
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($left<0){
				echo "<input type='button' id='napred' value='' onclick='next(".'"admin_message_show"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($left>=0&&$right<$broj_korisnika){
				echo "<input type='button' id='napred' value='' onClick='next(".'"admin_message_show"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"admin_message_show"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($right>=$broj_korisnika){
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"admin_message_show"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}
	
			echo "</form>";
			echo "</div>";
		}else{
			echo "<div class='admin_title'>Nema korisnika</div>";
			echo "<form name='stranicenje'>";
			echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			echo "</form>";
		}
	}
	
	mysql_close($konekcija);
?>
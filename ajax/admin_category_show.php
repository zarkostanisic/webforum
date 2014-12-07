<?php 
	include("../inc/konekcija.inc");
	
	$upit_podesavanja="SELECT * FROM podesavanja WHERE id_podesavanja='1'";
	$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
	if($rezultat_podesavanja){
		$broj=mysql_num_rows($rezultat_podesavanja);
		if($broj==1){
			$podesavanje=mysql_fetch_array($rezultat_podesavanja);
		}
	}
	
	$s=$_GET['s'];
	$broj_po_strani=$podesavanje['broj_kategorija'];
	$right=$s+$broj_po_strani;
	$left=$s-$broj_po_strani;
	$upit_kategorije_broj="SELECT * FROM kategorije";
	$rezultat_kategorije_broj=mysql_query($upit_kategorije_broj,$konekcija);
	if($rezultat_kategorije_broj){
		$broj_kategorija=mysql_num_rows($rezultat_kategorije_broj);
	}
	
	$upit_kategorije="SELECT * FROM kategorije LIMIT $broj_po_strani OFFSET $s";
	$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
	if($rezultat_kategorije){
		$broj=mysql_num_rows($rezultat_kategorije);
		if($broj==0&&$s!=0){
			$s-=$broj_po_strani;
		}
	}
	
	$upit_kategorije="SELECT * FROM kategorije LIMIT $broj_po_strani OFFSET $s";
	$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
	if($rezultat_kategorije){
		$broj=mysql_num_rows($rezultat_kategorije);
		if($broj>0){
			while($kategorija=mysql_fetch_array($rezultat_kategorije)){
				echo "<div class='admin_category'>";
				echo "<div class='admin_category_top'><input type='button' id='".$kategorija['id_kategorije']."' onClick='delete_category(this);' class='delete'/></div>";
				echo "<div class='admin_category_center'>".$kategorija['naziv_kategorije']."</div>";
				echo "<div class='admin_category_bottom'><a href='change_category.php?category=".$kategorija['id_kategorije']."' class='change'>Izmeni</a></div>";
				echo "</div>";
			}
			echo "<div class='pagging'>";
			echo "<form name='stranicenje'>";
	
			if($broj_kategorija<=$broj_po_strani){
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($left<0){
				echo "<input type='button' id='napred' value='' onclick='next(".'"admin_category_show"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($left>=0&&$right<$broj_kategorija){
				echo "<input type='button' id='napred' value='' onClick='next(".'"admin_category_show"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"admin_category_show"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($right>=$broj_kategorija){
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"admin_category_show"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}
	
			echo "</form>";
			echo "</div>";
		}else{
			echo "<div class='admin_title'>Nema kategorija</div>";
			echo "<form name='stranicenje'>";
			echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			echo "</form>";
		}
	}
	mysql_close($konekcija);
?>
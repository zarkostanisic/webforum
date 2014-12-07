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
	
	$id_kategorije=$_GET['category_id'];
	if(isset($_GET['s'])){
		$s=$_GET['s'];
	}else{
		$s=0;
	}
	$broj_po_strani=$podesavanje['broj_podkategorija'];
	$right=$s+$broj_po_strani;
	$left=$s-$broj_po_strani;
	
	if($id_kategorije=="0"){
		$upit_podkategorije_broj="SELECT * FROM podkategorije p JOIN kategorije k ON p.id_kategorije=k.id_kategorije";
	}else{
		$upit_podkategorije_broj="SELECT * FROM podkategorije p JOIN kategorije k ON p.id_kategorije=k.id_kategorije WHERE p.id_kategorije='".$id_kategorije."'";
	}
	$rezultat_podkategorije_broj=mysql_query($upit_podkategorije_broj,$konekcija);
	if($rezultat_podkategorije_broj){
		$broj_podkategorija=mysql_num_rows($rezultat_podkategorije_broj);
	}
	
	if($id_kategorije=="0"){
		$upit_podkategorije="SELECT * FROM podkategorije p JOIN kategorije k ON p.id_kategorije=k.id_kategorije LIMIT $broj_po_strani OFFSET $s";
	}else{
		$upit_podkategorije="SELECT * FROM podkategorije p JOIN kategorije k ON p.id_kategorije=k.id_kategorije WHERE p.id_kategorije='".$id_kategorije."' LIMIT $broj_po_strani OFFSET $s";
	}
	$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
	if($rezultat_podkategorije){
		$broj=mysql_num_rows($rezultat_podkategorije);
		if($broj==0&&$s!=0){
			$s-=$broj_po_strani;
		}
	}
	
	
	if($id_kategorije=="0"){
		$upit_podkategorije="SELECT * FROM podkategorije p JOIN kategorije k ON p.id_kategorije=k.id_kategorije LIMIT $broj_po_strani OFFSET $s";
	}else{
		$upit_podkategorije="SELECT * FROM podkategorije p JOIN kategorije k ON p.id_kategorije=k.id_kategorije WHERE p.id_kategorije='".$id_kategorije."' LIMIT $broj_po_strani OFFSET $s";
	}
	$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
	if($rezultat_podkategorije){
		$broj=mysql_num_rows($rezultat_podkategorije);
		if($broj>0){
			while($podkategorija=mysql_fetch_array($rezultat_podkategorije)){
				echo "<div class='admin_subcategory'>";
				echo "<div class='admin_subcategory_top'><input type='button' id='".$podkategorija['id_podkategorije']."' onClick='delete_subcategory(this);' class='delete'/></div>";
				echo "<div class='admin_subcategory_center'>".$podkategorija['naziv_podkategorije']."</div>";
				echo "<div class='admin_subcategory_bottom'><a href='change_subcategory.php?subcategory=".$podkategorija['id_podkategorije']."' class='change'>Izmeni</a></div>";
				echo "</div>";
			}
			echo "<div class='pagging'>";
			echo "<form name='stranicenje'>";
	
			if($broj_podkategorija<=$broj_po_strani){
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($left<0){
				echo "<input type='button' id='napred' value='' onclick='next(".'"admin_subcategory_show"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($left>=0&&$right<$broj_podkategorija){
				echo "<input type='button' id='napred' value='' onClick='next(".'"admin_subcategory_show"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"admin_subcategory_show"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($right>=$broj_podkategorija){
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"admin_subcategory_show"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}
	
			echo "</form>";
			echo "</div>";
		}else{
			echo "<div class='admin_title'>Nema podkategorija</div>";
			echo "<form name='stranicenje'>";
			echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			echo "</form>";
		}
	}
	
	mysql_close($konekcija);
?>
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
	
	if(isset($_GET['s'])){
		$s=$_GET['s'];
	}else{
		$s=0;
	}
	
	$broj_po_strani=$podesavanje['broj_tema'];
	$right=$s+$broj_po_strani;
	$left=$s-$broj_po_strani;
	
	$id_kategorije=$_GET['category_id'];
	$id_podkategorije=$_GET['subcategory_id'];
	
	if($id_kategorije=="0"){
		$upit_teme_broj="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije";
	}
	
	if((!isset($id_podkategorije))&&($id_kategorije!="0")){
		$upit_teme_broj="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_kategorije='".$id_kategorije."'";
	}
	
	if(($id_podkategorije=="0")&&($id_kategorije!="0")){
		$upit_teme_broj="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_kategorije='".$id_kategorije."'";
	}
	
	if(($id_podkategorije!="0")&&($id_kategorije!="0")){
		$upit_teme_broj="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_podkategorije='".$id_podkategorije."'";
	}
	$rezultat_teme_broj=mysql_query($upit_teme_broj,$konekcija);
	if($rezultat_teme_broj){
		$broj_tema=mysql_num_rows($rezultat_teme_broj);
	}
	
	
	if($id_kategorije=="0"){
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije LIMIT $broj_po_strani OFFSET $s";
	}
	
	if((!isset($id_podkategorije))&&($id_kategorije!="0")){
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_kategorije='".$id_kategorije."' LIMIT $broj_po_strani OFFSET $s";
	}
	
	if(($id_podkategorije=="0")&&($id_kategorije!="0")){
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_kategorije='".$id_kategorije."' LIMIT $broj_po_strani OFFSET $s";
	}
	
	if(($id_podkategorije!="0")&&($id_kategorije!="0")){
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_podkategorije='".$id_podkategorije."' LIMIT $broj_po_strani OFFSET $s";
	}
	$rezultat_teme=mysql_query($upit_teme,$konekcija);
	if($rezultat_teme){
		$broj=mysql_num_rows($rezultat_teme);
		if($broj==0&&$s!=0){
			$s-=$broj_po_strani;
		}
	}

	
	if($id_kategorije=="0"){
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije LIMIT $broj_po_strani OFFSET $s";
	}
	
	if((!isset($id_podkategorije))&&($id_kategorije!="0")){
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_kategorije='".$id_kategorije."' LIMIT $broj_po_strani OFFSET $s";
	}
	
	if(($id_podkategorije=="0")&&($id_kategorije!="0")){
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_kategorije='".$id_kategorije."' LIMIT $broj_po_strani OFFSET $s";
	}
	
	if(($id_podkategorije!="0")&&($id_kategorije!="0")){
		$upit_teme="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_podkategorije='".$id_podkategorije."' LIMIT $broj_po_strani OFFSET $s";
	}
	$rezultat_teme=mysql_query($upit_teme,$konekcija);
	if($rezultat_teme){
		$broj=mysql_num_rows($rezultat_teme);
		if($broj>0){
			while($tema=mysql_fetch_array($rezultat_teme)){
				echo "<div class='admin_theme'>";
				echo "<div class='admin_theme_top'><input type='button' id='".$tema['id_teme']."' onClick='delete_theme(this);' class='delete'/></div>";
				echo "<div class='admin_theme_center'>".$tema['naziv_teme']."</div>";
				echo "<div class='admin_theme_bottom'><a href='change_theme.php?thema=".$tema['id_teme']."' class='change'>Izmeni</a></div>";
				echo "</div>";
			}
			echo "<div class='pagging'>";
			echo "<form name='stranicenje'>";
	
			if($broj_tema<=$broj_po_strani){
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($left<0){
				echo "<input type='button' id='napred' value='' onclick='next(".'"admin_theme_show"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($left>=0&&$right<$broj_tema){
				echo "<input type='button' id='napred' value='' onClick='next(".'"admin_theme_show"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"admin_theme_show"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}else if($right>=$broj_tema){
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"admin_theme_show"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			}
	
			echo "</form>";
			echo "</div>";
		}else{
			echo "<div class='admin_title'>Nema tema</div>";
			echo "<form name='stranicenje'>";
			echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			echo "</form>";
		}
	}
	
	mysql_close($konekcija);
?>
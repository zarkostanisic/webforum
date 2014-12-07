<?php session_start();
	include("../inc/konekcija.inc");
				
	$id_podkategorije=$_GET['subcategory'];
		
	$s=$_GET['s'];
	
	if(isset($_SESSION['id_korisnika'])){
		$upit_podesavanja="SELECT * FROM podesavanja WHERE id_korisnika='".@$_SESSION['id_korisnika']."'";
		$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
		if($rezultat_podesavanja){
			$broj_podesavanja=mysql_num_rows($rezultat_podesavanja);
			if($broj_podesavanja==1){
				$podesavanje=mysql_fetch_array($rezultat_podesavanja);
				$broj_po_strani=$podesavanje['broj_tema'];
			}else{
				$upit_podesavanja="SELECT * FROM podesavanja WHERE id_podesavanja='1'";
				$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
				if($rezultat_podesavanja){
					$broj_podesavanja=mysql_num_rows($rezultat_podesavanja);
					if($broj_podesavanja==1){
						$podesavanje=mysql_fetch_array($rezultat_podesavanja);
						$broj_po_strani=$podesavanje['broj_tema'];
					}
				}
			}
		}
	}else{
		$upit_podesavanja="SELECT * FROM podesavanja WHERE id_podesavanja='1'";
		$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
		if($rezultat_podesavanja){
			$broj_podesavanja=mysql_num_rows($rezultat_podesavanja);
			if($broj_podesavanja==1){
				$podesavanje=mysql_fetch_array($rezultat_podesavanja);
				$broj_po_strani=$podesavanje['broj_tema'];
			}
		}
	}
	
	$right=$s+$broj_po_strani;
	$left=$s-$broj_po_strani;
	
	$upit_podkategorije="SELECT * FROM podkategorije WHERE id_podkategorije='".$id_podkategorije."'";
	$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
	if($rezultat_podkategorije){
		$broj=mysql_num_rows($rezultat_podkategorije);
	}
	
	$upit_broj_tema="SELECT * FROM teme t JOIN podkategorije p ON t.id_podkategorije=p.id_podkategorije WHERE p.id_podkategorije='".$id_podkategorije."'";
	$rezultat_broj_tema=mysql_query($upit_broj_tema,$konekcija);
	if($rezultat_broj_tema){
		$broj_tema=mysql_num_rows($rezultat_broj_tema);
	}
	
	$upit_teme="SELECT * FROM teme t JOIN korisnici k ON t.id_korisnika=k.id_korisnika WHERE id_podkategorije='".$id_podkategorije."' ORDER BY t.id_teme DESC LIMIT $broj_po_strani OFFSET $s";
	$rezultat_teme=mysql_query($upit_teme,$konekcija);
	if($rezultat_teme){
		$broj=mysql_num_rows($rezultat_teme);
		if($broj>0){
			echo "<div class='theme_title'>";
			echo "<div class='theme_activity'>Status</div>";
			echo "<div class='theme_name'>Naziv teme</div>";
			echo "<div class='theme_post'>Postovi</div>";
			echo "<div class='theme_last_post'>Poslednji post</div>";
			echo "<div class='theme_open'>Otvorio</div>";
			echo "</div>";
			while($tema=mysql_fetch_array($rezultat_teme)){
							
				$upit_postovi="SELECT * FROM postovi p JOIN teme t ON p.id_teme=t.id_teme WHERE t.id_teme='".$tema['id_teme']."'";
				$rezultat_postovi=mysql_query($upit_postovi,$konekcija);
				if($rezultat_postovi){
					$broj_postova=mysql_num_rows($rezultat_postovi);
				}
						
				$upit_poslednji_post="SELECT * FROM postovi p JOIN korisnici k ON p.id_korisnika=k.id_korisnika WHERE p.id_teme='".$tema['id_teme']."' ORDER BY p.id_posta DESC LIMIT 1";
				$rezultat_poslednji_post=mysql_query($upit_poslednji_post,$konekcija);
							
				echo "<div class='theme'>";
				echo "<div class='theme_activity'>";
					if(@$_SESSION['uloga']=="administrator"){
						if($tema['status']=='1'){
							echo "<input type='button' id='1' value=' ' name='".$tema['id_teme']."' class='open' onClick='lock_theme(this);'/>";
						}
						if($tema['status']=='2'){
							echo "<input type='button' id='2' value=' ' name='".$tema['id_teme']."' class='lock' onClick='open_theme(this);'/>";
						}
					}else{
						if($tema['status']=='1'){
							echo "<img src='images/open.png'/>";
						}
						if($tema['status']=='2'){
							echo "<img src='images/lock.png'/>";
						}
					}
				echo "</div>";
				echo "<div class='theme_name'><a href='show_posts.php?thema=".$tema['id_teme']."'>".$tema['naziv_teme']."</a></div>";
				echo "<div class='theme_post'>".$broj_postova."</div>";
							
				if($rezultat_poslednji_post){
					$broj=mysql_num_rows($rezultat_poslednji_post);
					if($broj==1){
						$poslednji_post=mysql_fetch_array($rezultat_poslednji_post);
									
						$dan_post=substr($poslednji_post['datum_objave'],8,2);
						$mesec_post=substr($poslednji_post['datum_objave'],5,2);
						$godina_post=substr($poslednji_post['datum_objave'],0,4);
						$vreme_post=substr($poslednji_post['datum_objave'],11,8);
						$datum_post=$dan_post."-".$mesec_post."-".$godina_post." ".$vreme_post;
									
						echo "<div class='theme_last_post'><a href='show_posts.php?thema=".$poslednji_post['id_teme']."'>".$poslednji_post['korisnicko_ime']."</a><p>".$datum_post."</p></div>";
					}else{
						echo "<div class='theme_last_post'>/</div>";
					}
				}
							
				$dan=substr($tema['datum_postavljanja'],8,2);
				$mesec=substr($tema['datum_postavljanja'],5,2);
				$godina=substr($tema['datum_postavljanja'],0,4);
				$vreme=substr($tema['datum_postavljanja'],11,8);
				$datum=$dan."-".$mesec."-".$godina." ".$vreme;
							
				echo "<div class='theme_open'><a href='profile.php?user=".$tema['id_korisnika']."'>".$tema['korisnicko_ime']."</a><p>".$datum."</p></div>";
				echo "</div>";
			}
			
			if($broj_tema<=$broj_po_strani){ 
			}else if($left<0){
				echo "<div class='pagging'>";
				echo "<form name='stranicenje'>";
				echo "<input type='button' id='napred' value='' onclick='next(".'"show_themes"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "</form>";
				echo "</div>";
			}else if($left>=0&&$right<$broj_tema){
				echo "<div class='pagging'>";
				echo "<form name='stranicenje'>";
				echo "<input type='button' id='napred' value='' onClick='next(".'"show_themes"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"show_themes"'.");' class='back'/>";
				echo "</form>";
				echo "</div>";
			}else if($right>=$broj_tema){
				echo "</form>";
				echo "</div>";
				echo "<div class='pagging'>";
				echo "<form name='stranicenje'>";
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"show_themes"'.");' class='back'/>";
				echo "</form>";
				echo "</div>";
			}
		}else{
			echo "<div class='admin_title'>Nema tema</div>";
		}
	}
	mysql_close($konekcija);
?>
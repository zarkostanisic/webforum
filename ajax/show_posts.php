<?php session_start();
	include("../inc/konekcija.inc");
				
	$id_teme=$_GET['thema'];
	
	$s=$_GET['s'];
	
	if(isset($_SESSION['id_korisnika'])){
		$upit_podesavanja="SELECT * FROM podesavanja WHERE id_korisnika='".@$_SESSION['id_korisnika']."'";
		$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
		if($rezultat_podesavanja){
			$broj_podesavanja=mysql_num_rows($rezultat_podesavanja);
			if($broj_podesavanja==1){
				$podesavanje=mysql_fetch_array($rezultat_podesavanja);
				$broj_po_strani=$podesavanje['broj_postova'];
			}else{
				$upit_podesavanja="SELECT * FROM podesavanja WHERE id_podesavanja='1'";
				$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
				if($rezultat_podesavanja){
					$broj_podesavanja=mysql_num_rows($rezultat_podesavanja);
					if($broj_podesavanja==1){
						$podesavanje=mysql_fetch_array($rezultat_podesavanja);
						$broj_po_strani=$podesavanje['broj_postova'];
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
				$broj_po_strani=$podesavanje['broj_postova'];
			}
		}
	}
	
	$right=$s+$broj_po_strani;
	$left=$s-$broj_po_strani;
	
	$upit_broj_postova="SELECT * FROM postovi p JOIN teme t ON p.id_teme=t.id_teme WHERE p.id_teme='".$id_teme."'";
	$rezultat_broj_postova=mysql_query($upit_broj_postova,$konekcija);
	if($rezultat_broj_postova){
		$broj_postova=mysql_num_rows($rezultat_broj_postova);
	}
	
	$upit_teme="SELECT * FROM  teme t JOIN korisnici k ON t.id_korisnika=k.id_korisnika WHERE t.id_teme='".$id_teme."'";
	$rezultat_teme=mysql_query($upit_teme,$konekcija);
	if($rezultat_teme){
		$broj=mysql_num_rows($rezultat_teme);
		if($broj==1){
			$tema=mysql_fetch_array($rezultat_teme);
			$dan=substr($tema['datum_postavljanja'],8,2);
			$mesec=substr($tema['datum_postavljanja'],5,2);
			$godina=substr($tema['datum_postavljanja'],0,4);
			$vreme=substr($tema['datum_postavljanja'],11,8);
			$datum=$dan."-".$mesec."-".$godina." ".$vreme;
			echo "<div class='post' style='border:1px solid #ff9f00;'>";
			echo "<div class='post_top'>";
			echo "<div class='post_user_top'><a href='profile.php?user=".$tema['id_korisnika']."'>".$tema['korisnicko_ime']."</a></div>";
			echo "<div class='post_post_top'><a href='show_posts.php?thema=".$tema['id_teme']."'>".$tema['naziv_teme']."</a></div>";
			echo "</div>";
			echo "<div class='post_center'>";
			echo "<div class='post_user_center'><img src='pictures/users/small/".$tema['slika_korisnika']."'/></div>";
			echo "<div class='post_post_center'>".$tema['pitanje']."</div>";
			echo "</div>";
			echo "<div class='post_bottom'>";
			echo "<div class='post_user_bottom'>".$datum."</div>";
			echo "<div class='post_post_bottom'></div>";
			echo "</div>";
			echo "</div>";
		}
	}
	
	$upit_postovi="SELECT * FROM postovi p JOIN teme t ON p.id_teme=t.id_teme JOIN korisnici k ON p.id_korisnika=k.id_korisnika WHERE p.id_teme='".$id_teme."' ORDER BY p.id_posta DESC LIMIT $broj_po_strani OFFSET $s";
	$rezultat_postovi=mysql_query($upit_postovi,$konekcija);
	if($rezultat_postovi){
		$broj=mysql_num_rows($rezultat_postovi);
		if($broj==0&&$s!=0){
			$s-=$broj_po_strani;
		}
	}
		
	$upit_postovi="SELECT * FROM postovi p JOIN teme t ON p.id_teme=t.id_teme JOIN korisnici k ON p.id_korisnika=k.id_korisnika WHERE p.id_teme='".$id_teme."' ORDER BY p.id_posta DESC LIMIT $broj_po_strani OFFSET $s";
	$rezultat_postovi=mysql_query($upit_postovi,$konekcija);
	if($rezultat_postovi){
		$broj=mysql_num_rows($rezultat_postovi);
		if($broj>0){
			while($post=mysql_fetch_array($rezultat_postovi)){
				$dan=substr($post['datum_objave'],8,2);
				$mesec=substr($post['datum_objave'],5,2);
				$godina=substr($post['datum_objave'],0,4);
				$vreme=substr($post['datum_objave'],11,8);
				$datum=$dan."-".$mesec."-".$godina." ".$vreme;
				echo "<div class='post'>";
				echo "<div class='post_top'>";
				echo "<div class='post_user_top'><a href='profile.php?user=".$post['id_korisnika']."'>".$post['korisnicko_ime']."</a></div>";
				echo "<div class='post_post_top'>";
				echo "<a href='show_posts.php?thema=".$post['id_teme']."'>".$post['naziv_teme']."</a>";
					if(isset($_SESSION['uloga'])&&($_SESSION['uloga']=="administrator")){
						echo "<input type='button' id='".$post['id_posta']."' onClick='admin_delete_post(this);' class='delete'/>";
					}
				echo "</div>";
				echo "</div>";
				echo "<div class='post_center'>";
				echo "<div class='post_user_center'><img src='pictures/users/small/".$post['slika_korisnika']."'/></div>";
				echo "<div class='post_post_center'>".$post['post']."</div>";
				echo "</div>";
				echo "<div class='post_bottom'>";
				echo "<div class='post_user_bottom'>".$datum."</div>";
				echo "<div class='post_post_bottom'>";
					if(isset($_SESSION['uloga'])&&($_SESSION['uloga']=="administrator")){
						echo "<a href='change_post.php?post=".$post['id_posta']."'>Izmeni</a>";
					}
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}
			if($broj_postova<=$broj_po_strani){
				echo "<div class='pagging'>";
				echo "<form name='stranicenje'>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
				echo "</form>";
				echo "</div>";
			}else if($left<0){
				echo "<div class='pagging'>";
				echo "<form name='stranicenje'>";
				echo "<input type='button' id='napred' value='' onclick='next(".'"show_posts"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
				echo "</form>";
				echo "</div>";
			}else if($left>=0&&$right<$broj_postova){
				echo "<div class='pagging'>";
				echo "<form name='stranicenje'>";
				echo "<input type='button' id='napred' value='' onClick='next(".'"show_posts"'.");' class='next'/>";
				echo "<input type='hidden' id='right' value='".$right."'/>";
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"show_posts"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
				echo "</form>";
				echo "</div>";
			}else if($right>=$broj_postova){
				echo "<div class='pagging'>";
				echo "<form name='stranicenje'>";
				echo "<input type='hidden' id='left' value='".$left."'/>";
				echo "<input type='button' id='nazad' value='' onClick='back(".'"show_posts"'.");' class='back'/>";
				echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
				echo "</form>";
				echo "</div>";
			}
		}else{
			echo "<div class='admin_title'>Nema postova</div>";
			echo "<form name='stranicenje'>";
			echo "<div id='stranicenje'><input type='hidden' id='s' value='".$s."'/></div>";
			echo "</form>";
		}
	}
							
	mysql_close($konekcija);
?>
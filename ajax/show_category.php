<?php session_start(); 
	include("../inc/konekcija.inc");
	
	$upit_kategorije="SELECT * FROM kategorije";
	$rezultat_kategorije=mysql_query($upit_kategorije,$konekcija);
	if($rezultat_kategorije){
		$broj=mysql_num_rows($rezultat_kategorije);
		if($broj>0){
			while($kategorija=mysql_fetch_array($rezultat_kategorije)){
				
				$upit_podkategorije="SELECT * FROM podkategorije WHERE id_kategorije='".$kategorija['id_kategorije']."'";
				$rezultat_podkategorije=mysql_query($upit_podkategorije,$konekcija);
				if($rezultat_podkategorije){
					$broj=mysql_num_rows($rezultat_podkategorije);
					if($broj>0){
						echo "<div class='category'>".$kategorija['naziv_kategorije']."</div>";
						echo "<div class='subcategory_title'>";
						echo "<div class='subcategory_activity'>Status</div>";
						echo "<div class='subcategory_name'>Naziv</div>";
						echo "<div class='subcategory_theme'>Teme</div>";
						echo "<div class='subcategory_post'>Postovi</div>";
						echo "<div class='subcategory_last_post'>Poslednji post u temi</div>";
						echo "</div>";
						while($podkategorija=mysql_fetch_array($rezultat_podkategorije)){
							
							$upit_teme="SELECT * FROM teme WHERE id_podkategorije='".$podkategorija['id_podkategorije']."'";
							$rezultat_teme=mysql_query($upit_teme,$konekcija);
							if($rezultat_teme){
								$broj_tema=mysql_num_rows($rezultat_teme);
							}
							
							$upit_postovi="SELECT * FROM postovi p JOIN teme t ON p.id_teme=t.id_teme WHERE t.id_podkategorije='".$podkategorija['id_podkategorije']."'";
							$rezultat_postovi=mysql_query($upit_postovi,$konekcija);
							if($rezultat_postovi){
								$broj_postova=mysql_num_rows($rezultat_postovi);
							}
							
							echo "<div class='subcategory'>";
							echo "<div class='subcategory_activity'>";
								if(@$_SESSION['uloga']=="administrator"){
									if($podkategorija['status']=='1'){
										echo "<input type='button' id='1' value=' ' name='".$podkategorija['id_podkategorije']."' class='open' onClick='lock_subcategory(this);'/>";
									}
									if($podkategorija['status']=='2'){
										echo "<input type='button' id='2' value=' ' name='".$podkategorija['id_podkategorije']."' class='lock' onClick='open_subcategory(this);'/>";
									}
								}else{
									if($podkategorija['status']=='1'){
										echo "<img src='images/open.png'/>";
									}
									if($podkategorija['status']=='2'){
										echo "<img src='images/lock.png'/>";
									}
								}
							echo "</div>";
							echo "<div class='subcategory_name'><a href='show_themes.php?subcategory=".$podkategorija['id_podkategorije']."'>".$podkategorija['naziv_podkategorije']."</a></div>";
							echo "<div class='subcategory_theme'><a href='show_themes.php?subcategory=".$podkategorija['id_podkategorije']."'>".$broj_tema."</a></div>";
							echo "<div class='subcategory_post'>".$broj_postova."</div>";
							
							$upit_poslednji_post="SELECT * FROM postovi pos JOIN teme t ON pos.id_teme=t.id_teme JOIN podkategorije pod ON t.id_podkategorije=pod.id_podkategorije WHERE pod.id_podkategorije='".$podkategorija['id_podkategorije']."' ORDER BY pos.id_posta DESC LIMIT 1";
							$rezultat_poslednji_post=mysql_query($upit_poslednji_post,$konekcija);
							
							if($rezultat_poslednji_post){
								$broj=mysql_num_rows($rezultat_poslednji_post);
								if($broj==1){
									$poslednji_post=mysql_fetch_array($rezultat_poslednji_post);
									$dan=substr($poslednji_post['datum_objave'],8,2);
									$mesec=substr($poslednji_post['datum_objave'],5,2);
									$godina=substr($poslednji_post['datum_objave'],0,4);
									$vreme=substr($poslednji_post['datum_objave'],11,8);
									$datum=$dan."-".$mesec."-".$godina." ".$vreme;
									
									echo "<div class='subcategory_last_post'><a href='show_posts.php?thema=".$poslednji_post['id_teme']."'>".$poslednji_post['naziv_teme']."</a><p>".$datum."</p></div>";
								}else{
									echo "<div class='subcategory_last_post'>/</div>";
								}
							}
							
							echo "</div>";
						}
					}
					
				}
				
			}
		}
	}
	mysql_close($konekcija);
?>
<?php 
	include("../inc/konekcija.inc");
	$upit_online="SELECT * FROM online o JOIN korisnici k ON o.id_korisnika=k.id_korisnika WHERE o.status='da'";
	$rezultat_online=mysql_query($upit_online,$konekcija);
	if($rezultat_online){
		$broj=mysql_num_rows($rezultat_online);
		if($broj>0){
			echo "<div class='online_title'>";
			echo "<div class='online_user'>Korisnik</div>";
			echo "<div class='online_last_post'>Poslednji post u temi</div>";
			echo "<div class='online_last_login'>Poslednje logovanje</div>";
			echo "</div>";
			while($online=mysql_fetch_array($rezultat_online)){
				$poslednji_post="SELECT * FROM postovi p JOIN korisnici k ON p.id_korisnika=k.id_korisnika JOIN teme t ON p.id_teme=t.id_teme WHERE p.id_korisnika='".$online['id_korisnika']."' ORDER BY p.id_posta DESC LIMIT 1";
				$rezultat_poslednji_post=mysql_query($poslednji_post,$konekcija);
							
				echo "<div class='online'>";
				echo "<div class='online_user'><a href='profile.php?user=".$online['id_korisnika']."' class='forum_list_link'>".$online['korisnicko_ime']."</a></div>";
							
				if($rezultat_poslednji_post){
					$broj=mysql_num_rows($rezultat_poslednji_post);
					echo "<div class='online_last_post'>";
					if($broj>0){
						$poslednji_post=mysql_fetch_array($rezultat_poslednji_post);
						$dan_post=substr($poslednji_post['datum_objave'],8,2);
						$mesec_post=substr($poslednji_post['datum_objave'],5,2);
						$godina_post=substr($poslednji_post['datum_objave'],0,4);
						$vreme_post=substr($poslednji_post['datum_objave'],11,8);
						$datum_post=$dan_post."-".$mesec_post."-".$godina_post." ".$vreme_post;
									
						echo "<a href='show_posts.php?thema=".$poslednji_post['id_teme']."' class='forum_list_link'>".$poslednji_post['naziv_teme']."</a><p class='forum_list_paragraph'>".$datum_post."</p>";
					}else{
						echo "/";
					}
					echo "</div>";
				}
				$dan=substr($online['datum_logovanja'],8,2);
				$mesec=substr($online['datum_logovanja'],5,2);
				$godina=substr($online['datum_logovanja'],0,4);
				$vreme=substr($online['datum_logovanja'],11,8);
				$datum=$dan."-".$mesec."-".$godina." ".$vreme;
							
				echo "<div class='online_last_login'>".$datum."</div>";
				echo "</div>";
							
			}
		}
	}
	mysql_close($konekcija);
?>
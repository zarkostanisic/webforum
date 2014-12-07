<?php session_start();
	/*broj online korisnika*/
	include("../inc/konekcija.inc");
		$upit_trajanje_svi="SELECT * FROM online WHERE status='da'";
		$rezultat_trajanje_svi=mysql_query($upit_trajanje_svi,$konekcija);
		if($rezultat_trajanje_svi){
			$broj=mysql_num_rows($rezultat_trajanje_svi);
			if($broj>0){
				while($trajanje=mysql_fetch_array($rezultat_trajanje_svi)){
					if((strtotime($trajanje['datum_logovanja'])+3600)<(strtotime(date("Y-m-d H:i:s")))){
						$upit_logout="UPDATE online SET status='ne' WHERE id_korisnika='".$trajanje['id_korisnika']."'";
						$rezultat_logout=mysql_query($upit_logout,$konekcija);
							
						if($trajanje['id_korisnika']==@$_SESSION['id_korisnika']){
							unset($_SESSION['id_korisnika']);
							unset($_SESSION['uloga']);
							unset($_SESSION['korisnicko_ime']);
							session_destroy();
						}
					}
				}
			}
		}
		
	$upit_online="SELECT * FROM online WHERE status='da'";
	$rezultat_online=mysql_query($upit_online,$konekcija);
	if($rezultat_online){
		$broj=mysql_num_rows($rezultat_online);
		if($broj>0){
			echo "Online: "."<a href='show_online.php'>".$broj."</a>";
		}else{
			echo "Online: 0";
		}
	}
	mysql_close($konekcija);
?>
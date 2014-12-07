<?php session_start();

		include("../inc/konekcija.inc");
		$korisnicko_ime=strtolower($_GET['username']);
		$sifra=md5(strtolower($_GET['password']));
		
		$upit_logovanje="SELECT * FROM korisnici k JOIN uloge u ON k.id_uloge=u.id_uloge WHERE k.korisnicko_ime='".$korisnicko_ime."' AND k.sifra='".$sifra."'";
		$rezultat_logovanje=mysql_query($upit_logovanje,$konekcija);
		
		if($rezultat_logovanje){
			$broj=mysql_num_rows($rezultat_logovanje);
			if($broj==1){
				$korisnik=mysql_fetch_array($rezultat_logovanje);
				$_SESSION['uloga']=$korisnik['naziv_uloge'];
				$_SESSION['korisnicko_ime']=$korisnik['korisnicko_ime'];
				$_SESSION['id_korisnika']=$korisnik['id_korisnika'];
				
				$upit_provera="SELECT * FROM online WHERE id_korisnika='".$korisnik['id_korisnika']."'";
				$rezultat_provera=mysql_query($upit_provera,$konekcija);
				if($rezultat_provera){
					$broj=mysql_num_rows($rezultat_provera);
					if($broj==0){
						$upit_online="INSERT INTO online VALUES('','".$korisnik['id_korisnika']."','2','da','".date("Y-m-d H:i:s")."')";
						$rezultat_online=mysql_query($upit_online,$konekcija);
					}else{
						$upit_online="UPDATE online SET status='da',datum_logovanja='".date("Y-m-d H:i:s")."' WHERE id_korisnika='".$_SESSION['id_korisnika']."'";
						$rezultat_online=mysql_query($upit_online,$konekcija);
					}
				}
			}
		}
		mysql_close($konekcija);
?>
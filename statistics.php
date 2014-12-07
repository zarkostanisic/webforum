
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
		include("./inc/head.inc");
	?>
</head>
<body onLoad="online();">
	<div id="container">
		<div id="top">
			<div id="online">
			</div>
			<div id="login_form">
			</div>
		</div>
		<div id="header">
			<?php 
				include("./inc/header.inc");
			?>
		</div>
		<div id="menu">
		</div>
		<div id="center_content">
			<?php 
				include("./inc/konekcija.inc");
				
				$upit_clanovi="SELECT * FROM korisnici";
				$rezultat_clanovi=mysql_query($upit_clanovi,$konekcija);
				if($rezultat_clanovi){
					$broj_clanova=mysql_num_rows($rezultat_clanovi);
				}
				
				$upit_m_clanovi="SELECT * FROM korisnici WHERE pol='m'";
				$rezultat_m_clanovi=mysql_query($upit_m_clanovi,$konekcija);
				if($rezultat_m_clanovi){
					$broj_m_clanova=mysql_num_rows($rezultat_m_clanovi);
				}
				
				$upit_z_clanovi="SELECT * FROM korisnici WHERE pol='z'";
				$rezultat_z_clanovi=mysql_query($upit_z_clanovi,$konekcija);
				if($rezultat_z_clanovi){
					$broj_z_clanova=mysql_num_rows($rezultat_z_clanovi);
				}
				
				$upit_p_clan="SELECT * FROM korisnici ORDER BY id_korisnika DESC LIMIT 1";
				$rezultat_p_clan=mysql_query($upit_p_clan,$konekcija);
				if($rezultat_p_clan){
					$broj_p_clan=mysql_num_rows($rezultat_p_clan);
					if($broj_p_clan==1){
						$poslednji_clan=mysql_fetch_array($rezultat_p_clan);
					}
				}
				
				$upit_teme="SELECT * FROM teme";
				$rezultat_teme=mysql_query($upit_teme,$konekcija);
				if($rezultat_teme){
					$broj_tema=mysql_num_rows($rezultat_teme);
				}
				
				$upit_postovi="SELECT * FROM postovi";
				$rezultat_postovi=mysql_query($upit_postovi,$konekcija);
				if($rezultat_postovi){
					$broj_postova=mysql_num_rows($rezultat_postovi);
				}
				
				$upit_pisma="SELECT * FROM pisma";
				$rezultat_pisma=mysql_query($upit_pisma,$konekcija);
				if($rezultat_pisma){
					$broj_pisama=mysql_num_rows($rezultat_pisma);
				}
				
				$upit_p_pisma="SELECT * FROM pisma WHERE status='1'";
				$rezultat_p_pisma=mysql_query($upit_p_pisma,$konekcija);
				if($rezultat_p_pisma){
					$broj_p_pisama=mysql_num_rows($rezultat_p_pisma);
				}
				
				$upit_pr_pisma="SELECT * FROM pisma WHERE status='2'";
				$rezultat_pr_pisma=mysql_query($upit_pr_pisma,$konekcija);
				if($rezultat_pr_pisma){
					$broj_pr_pisama=mysql_num_rows($rezultat_pr_pisma);
				}
				
				$upit_slike="SELECT * FROM korisnici WHERE slika_korisnika<>''";
				$rezultat_slike=mysql_query($upit_slike,$konekcija);
				if($rezultat_slike){
					$broj_slika=mysql_num_rows($rezultat_slike);
				}
				
				mysql_close($konekcija);
			?>
			<div class="admin_options" style="width:460px;margin-left:35px;">Broj članova <?php echo "(".$broj_clanova.")"; ?></a></div>
			<div class="admin_options" style="width:460px;margin-left:35px;">Muški članovi <?php echo "(".$broj_m_clanova.")"; ?></a></div>
			<div class="admin_options" style="width:460px;margin-left:35px;">Ženski članovi <?php echo "(".$broj_z_clanova.")"; ?></a></div>
			<div class="admin_options" style="width:460px;margin-left:35px;">Najnoviji član: <?php echo $poslednji_clan['korisnicko_ime']; ?></a></div>
			<div class="admin_options" style="width:460px;margin-left:35px;">Broj tema: <?php echo $broj_tema; ?></a></div>
			<div class="admin_options" style="width:460px;margin-left:35px;">Broj postova: <?php echo $broj_postova; ?></a></div>
			<div class="admin_options" style="width:460px;margin-left:35px;">Broj pisama u bazi: <?php echo $broj_pisama; ?></a></div>
			<div class="admin_options" style="width:460px;margin-left:35px;">Broj nepročitanih pisama: <?php echo $broj_p_pisama; ?></a></div>
			<div class="admin_options" style="width:460px;margin-left:35px;">Broj pročitanih pisama: <?php echo $broj_pr_pisama; ?></a></div>
			<div class="admin_options" style="width:460px;margin-left:35px;">Broj slika: <?php echo $broj_slika; ?></a></div>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
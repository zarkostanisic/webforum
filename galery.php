<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
		include("./inc/head.inc");
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.slika').lightBox();
		});
	</script>
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
			<div class="admin_title">Galerija</div>
		<?php
			
			include("./inc/konekcija.inc");
			
			@$s=$_GET['s'];
			if($s==""){
				$s=0;
			}
				
			$broj_po_strani=12;
			$desno=$s+$broj_po_strani;
			$levo=$s-$broj_po_strani;
				
			$upit_korisnici="SELECT * FROM korisnici WHERE slika_korisnika<>''";
			$rezultat_korisnici=mysql_query($upit_korisnici,$konekcija);
			if($rezultat_korisnici){
				$broj=mysql_num_rows($rezultat_korisnici);
			}
			
			$upit_korisnici="SELECT * FROM korisnici WHERE slika_korisnika <>'' LIMIT $broj_po_strani OFFSET $s";
			$rezultat_korisnici=mysql_query($upit_korisnici,$konekcija);
			
			if($rezultat_korisnici){
				$broj_korisnika=mysql_num_rows($rezultat_korisnici);
				if($broj_korisnika>0){
					while($korisnik=mysql_fetch_array($rezultat_korisnici)){
						echo "<div class='galery'>";
						echo "<div class='galery_image'><a href='pictures/users/".$korisnik['slika_korisnika']."' class='slika'><img src='pictures/users/small/".$korisnik['slika_korisnika']."' alt='".$korisnik['korisnicko_ime']."'/></a></div>";
						echo "<div class='galery_user'>".$korisnik['korisnicko_ime']."</div>";
						echo "</div>";
					}
					echo "<div class='pagging'>";	
					if($broj<=$broj_po_strani){
					}else if($levo<0){ 
						echo "<a href='galery.php?s=$desno' class='next'></a>";
					}else if($desno>=$broj){
						echo "<a href='galery.php?s=$levo' class='back'></a>";
					}else if($levo>=0&&$desno<$broj){
						echo "<a href='galery.php?s=$levo' class='back'></a><a href='galery.php?s=$desno' class='next'></a>";
					}
					echo "</div>";
				}else{
					echo "<div class='admin_title'>Nema slika</div>";
				}
			}
			
			mysql_close($konekcija);
		?>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
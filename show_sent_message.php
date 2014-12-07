<?php session_start(); 
	if(($_SESSION['uloga']!="administrator")&&($_SESSION['id_korisnika']!=$_GET['user'])){
		header("Location:index.php");
	}
?>
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
					@$id_poruke=$_GET['message'];
					$korisnik=$_GET['user'];
					$upit_pisma="SELECT * FROM pisma p JOIN korisnici k ON p.id_primaoca=k.id_korisnika WHERE p.id_pisma='".$id_poruke."' AND p.id_posiljaoca='".$korisnik."'";
					$rezultat_pisma=mysql_query($upit_pisma,$konekcija);
					if($rezultat_pisma){
						$broj=mysql_num_rows($rezultat_pisma);
						if($broj==1){
							$pismo=mysql_fetch_array($rezultat_pisma);
							echo "<div class='show_message'>";
							echo "<div class='show_message_top'>Kome: <a href='profile.php?user=".$pismo['id_primaoca']."'>".$pismo['korisnicko_ime']."</a></div>";
							echo "<div class='show_message_center'>".$pismo['pismo']."</div>";
							echo "<div class='show_message_bottom'>";
							echo "</div>";
							echo "</div>";
						}else{
							echo "<div class='admin_title'>Nedozvoljen pristup</div>";
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
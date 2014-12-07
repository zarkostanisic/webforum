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
			<div class="admin_title">Inbox</div>
			<?php 
				include("./inc/konekcija.inc");
				$upit_pisma="SELECT * FROM pisma p JOIN korisnici k ON p.id_posiljaoca=k.id_korisnika WHERE status='1' AND id_primaoca='".$_SESSION['id_korisnika']."'";
				$rezultat_pisma=mysql_query($upit_pisma,$konekcija);
				if($rezultat_pisma){
					$broj_primljenih=mysql_num_rows($rezultat_pisma);
				}
				
				if(isset($_GET['user'])){
					$korisnik=$_GET['user'];
				}else{
					$korisnik=$_SESSION['id_korisnika'];;
				}
				
				mysql_close($konekcija);
			?>
			<div class="message_category"><a href="new_messages.php?user=<?php echo $korisnik ?>">Nepročitane poruke <?php echo "(".$broj_primljenih.")";?></a></div>
			<div class="message_category"><a href="read_messages.php?user=<?php echo $korisnik ?>">Pročitane poruke </a></div>
			<div class="message_category"><a href="sent_messages.php?user=<?php echo $korisnik ?>">Poslate poruke</a></div>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
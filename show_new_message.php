<?php session_start(); 
	if(($_SESSION['uloga']!="administrator")&&($_SESSION['id_korisnika']!=@$_GET['user'])&&($_SESSION['id_korisnika']!=@$_POST['id_posiljaoca'])){
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
					@$korisnik=$_GET['user'];
					if(isset($_POST['posalji'])){
						@$id_poruke=$_POST['id_poruke'];
						$poruka=$_POST['poruka'];
						$korisnik=$_POST['id_posiljaoca'];
						$id_primaoca=$_POST['id_primaoca'];
						$id_posiljaoca=$_POST['id_posiljaoca'];
						@$datum=date("Y-m-d H:i:s");
						$reg_poruka="/^[A-ZŽĆČĐŠ]{1,2}[A-Za-zžćčđšŽĆČĐŠ\s\.\,\?\!\-0-9]{1,998}$/";
						$greska="";
						if(!(preg_match($reg_poruka,$poruka))){
							$greska="*";
						}
						if($greska==""){
							$upit_slanje="INSERT INTO pisma VALUES('','".$id_posiljaoca."','".$id_primaoca."','3','".$poruka."','".$datum."')";
							$rezultat_slanje=mysql_query($upit_slanje,$konekcija);
							if($rezultat_slanje){
								$ispis_odgovor="Uspešno";
							}
						}
					}
					
					$upit_status_pisma="UPDATE pisma SET status='2' WHERE id_pisma='".$id_poruke."'";
					$rezultat_status_pisma=mysql_query($upit_status_pisma,$konekcija);
					
					$upit_pisma="SELECT * FROM pisma p JOIN korisnici k ON p.id_posiljaoca=k.id_korisnika WHERE p.id_pisma='".$id_poruke."' AND p.id_primaoca='".$korisnik."'";
					$rezultat_pisma=mysql_query($upit_pisma,$konekcija);
					if($rezultat_pisma){
						$broj=mysql_num_rows($rezultat_pisma);
						if($broj==1){
							$pismo=mysql_fetch_array($rezultat_pisma);
							echo "<div class='show_message'>";
							echo "<div class='show_message_top'>Od: <a href='profile.php?user=".$pismo['id_posiljaoca']."'>".$pismo['korisnicko_ime']."</a></div>";
							echo "<div class='show_message_center'>".$pismo['pismo']."</div>";
							echo "<div class='show_message_bottom'>";
							echo "<form name='odgovor' action='".$_SERVER['PHP_SELF']."' method='post'>";
							if($_SESSION['id_korisnika']==$korisnik){
								echo "<table style='margin-left:160px;'>";
								echo "<tr>";
								echo "<td>Odgovor:</td>";
								echo "<td><textarea class='theme_textarea' name='poruka' style='margin-top:10px;margin-bottom:10px;'></textarea></td>";
								echo "<td class='error'>".@$greska."</td>";
								echo "<td><input type='hidden' name='id_poruke' value='".$id_poruke."'</td>";
								echo "<td><input type='hidden' name='id_primaoca' value='".$pismo['id_posiljaoca']."'</td>";
								echo "<td><input type='hidden' name='id_posiljaoca' value='".$pismo['id_primaoca']."'</td>";
								echo "<td><input type='submit' name='posalji' value=' ' class='sent_bt'/></td>";
								echo "<td>".@$ispis_odgovor."</td>";
								echo "</tr>";
								echo "</table>";
							}
							echo "</form>";
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
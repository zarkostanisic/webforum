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
			<?php 
				include("./inc/konekcija.inc");
				@$id_korisnika=$_GET['user'];
				
				if(isset($_POST['posalji'])){
					$id_korisnika=$_POST['id_korisnika'];
					$poruka=$_POST['poruka'];
					$id_posiljaoca=$_SESSION['id_korisnika'];
					@$datum=date("Y-m-d H:i:s");
					$reg_poruka="/^[A-ZŽĆČĐŠ]{1,2}[A-Za-zžćčđšŽĆČĐŠ\s\.\,\?\!\-0-9]{1,998}$/";
					$ispis_pisma="";
					
					if(!(preg_match($reg_poruka,$poruka))){
						$ispis_pisma="*";
					}
					
					if($ispis_pisma==""){
						$upit_pisma="INSERT INTO pisma VALUES('','".$id_posiljaoca."','".$id_korisnika."','1','".$poruka."','".$datum."')";
						$rezultat_pisma=mysql_query($upit_pisma,$konekcija);
						if($rezultat_pisma){
							$ispis_slanje="Uspešno";
						}
					}
				}
				
				$upit_korisnik="SELECT * FROM korisnici k JOIN uloge u ON k.id_uloge=u.id_uloge WHERE id_korisnika='".$id_korisnika."'";
				$rezultat_korisnik=mysql_query($upit_korisnik,$konekcija);
				
				if($rezultat_korisnik){
					$broj=mysql_num_rows($rezultat_korisnik);
					if($broj==1){
						$korisnik=mysql_fetch_array($rezultat_korisnik);
						echo "<table class='profile'>";
						echo "<tr>";
						echo "<td class='second_column' colspan='2' style='text-align:center;'>".strtoupper(substr($korisnik['korisnicko_ime'],0,1)).strtolower(substr($korisnik['korisnicko_ime'],1))."</td>";
						echo "</tr>";
						echo "<tr>";
						if($korisnik['slika_korisnika']!=""){
							echo "<td class='first_column' colspan='2' style='text-align:center;'><a href='pictures/users/".$korisnik['slika_korisnika']."' class='slika'><img src='pictures/users/small/".$korisnik['slika_korisnika']."' alt='".$korisnik['korisnicko_ime']."'/></a></td>";
						}else{
								echo "<td class='first_column' colspan='2' style='text-align:center;'><img src='pictures/users/small/default.png' alt='".$korisnik['korisnicko_ime']."'/></td>";
						}
						echo "</tr>";
						if(@$_SESSION['id_korisnika']!=$korisnik['id_korisnika']&&@isset($_SESSION['id_korisnika'])){
							echo "<form name='slanje' action='".$_SERVER['PHP_SELF']."' method='post'>";
							echo "<tr>";
							echo "<td class='first_column'>Posalji poruku:</td>";
							echo "<td class='second_column'>";
							echo "<textarea name='poruka' style='width:200px;max-width:200px;min-width:200px;height:60px;max-height:120px;min-height:60px;border:1px solid gray;font-size:12px;'></textarea><p class='error' style='float:right;color:red;'>".@$ispis_pisma."</p><br/>";
							echo "<input type='submit' name='posalji' value=' ' class='sent_bt' style='margin-top:5px;'/>".@$ispis_slanje;
							echo "<input type='hidden' name='id_korisnika' value='".$korisnik['id_korisnika']."'/>";
							echo "</td>";
							echo "</tr>";
							echo "</form>";
						}
						echo "<tr>";
						echo "<td class='first_column'>Ime:</td>";
						echo "<td class='second_column'>".$korisnik['ime']."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='first_column'>Prezime:</td>";
						echo "<td class='second_column'>".$korisnik['prezime']."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='first_column'>Email:</td>";
						echo "<td class='second_column'>".$korisnik['email']."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='first_column'>Telefon:</td>";
						echo "<td class='second_column'>".$korisnik['telefon']."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='first_column'>Datum rođenja:</td>";
						$dan=substr($korisnik['datum_rodjenja'],8,2);
						$mesec=substr($korisnik['datum_rodjenja'],5,2);
						$godina=substr($korisnik['datum_rodjenja'],0,4);
						$datum_rodjenja=$dan."-".$mesec."-".$godina;
						echo "<td class='second_column'>".$datum_rodjenja."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='first_column'>Pol:</td>";
						echo "<td class='second_column'>";
						if($korisnik['pol']=="m"){
							echo "Muški";
						}else{
							echo "Ženski";
						}
						echo "</td>";
						echo "<tr>";
						echo "<td class='first_column'>Status:</td>";
						echo "<td class='second_column'>".strtoupper(substr($korisnik['naziv_uloge'],0,1)).strtolower(substr($korisnik['naziv_uloge'],1))."</td>";
						echo "</tr>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='first_column'>Grad:</td>";
						echo "<td class='second_column'>";
						echo strtoupper(substr($korisnik['grad'],0,1));
						echo strtolower(substr($korisnik['grad'],1));
						echo "</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='first_column'>Datum registracije:</td>";
						$dan=substr($korisnik['datum_registracije'],8,2);
						$mesec=substr($korisnik['datum_registracije'],5,2);
						$godina=substr($korisnik['datum_registracije'],0,4);
						$vreme=substr($korisnik['datum_registracije'],11,8);
						$datum_registracije=$dan."-".$mesec."-".$godina." ".$vreme;
						echo "<td class='second_column'>".$datum_registracije."</td>";
						echo "</tr>";
						if(@$_SESSION['uloga']=="administrator"||@$_SESSION['id_korisnika']==$id_korisnika){
							echo "<tr>";
							echo "<td colspan='2' style='text-align:center;'><a href='change_profile.php?user=".$korisnik['id_korisnika']."'>Izmeni korisnički profil</a></td>";
							echo "</tr>";
						}
						echo "</table>";
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
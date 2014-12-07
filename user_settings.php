<?php session_start(); 
	if(($_SESSION['id_korisnika']!=@$_GET['user'])&&($_SESSION['id_korisnika']!=$_POST['id_korisnika'])){
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
				
				@$korisnik=$_GET['user'];
				
				if(isset($_POST['podesi'])){
					$korisnik=$_POST['id_korisnika'];
					$broj_tema=$_POST['teme'];
					$broj_postova=$_POST['postovi'];
					$broj_pisama=$_POST['pisma'];
					
					$upit_podesavanja="SELECT * FROM podesavanja WHERE id_korisnika='".$korisnik."'";
					$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
					if($rezultat_podesavanja){
						$broj=mysql_num_rows($rezultat_podesavanja);
						if($broj==1){
							$upit_izmena_podesavanja="UPDATE podesavanja SET broj_tema='".$broj_tema."',broj_postova='".$broj_postova."',broj_pisama='".$broj_pisama."' WHERE id_korisnika='".$korisnik."'";
							$rezultat_izmena_podesavanja=mysql_query($upit_izmena_podesavanja,$konekcija);
							if($rezultat_izmena_podesavanja){
								$ispis="Uspešno";
							}else{
								$ispis="Greška";
							}
						}else{
							$upit_dodavanje_podesavanja="INSERT INTO podesavanja VALUES('','".$korisnik."','','','','','".$broj_tema."','".$broj_postova."','".$broj_pisama."','')";
							$rezultat_dodavanje_podesavanja=mysql_query($upit_dodavanje_podesavanja,$konekcija);
							if($rezultat_dodavanje_podesavanja){
								$ispis="Uspešno";
							}else{
								$ispis="Greška";
							}
						}
					}
				}
				
				$upit_podesavanja="SELECT * FROM podesavanja WHERE id_korisnika='".$korisnik."'";
				$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
				if($rezultat_podesavanja){
					$broj=mysql_num_rows($rezultat_podesavanja);
					if($broj==1){
						$podesavanje=mysql_fetch_array($rezultat_podesavanja);
					}
				}
				mysql_close($konekcija);
			?>
			<form name="podesavanja" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<table style="margin-left:400px;" class="registration">
				<tr>
					<td class="first_column">Broj tema:</td>
					<td class="second_column">
						<select name="teme" class="set_select">
							<?php 
								for($i=2;$i<=20;$i++){
									if($i%2==0){
										if($i==$podesavanje['broj_tema']){
											echo "<option value='".$i."' selected>".$i."</option>";
										}else{
											echo "<option value='".$i."'>".$i."</option>";
										}
									}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="first_column">Broj postova:</td>
					<td class="second_column">
						<select name="postovi" class="set_select">
							<?php 
								for($i=2;$i<=20;$i++){
									if($i%2==0){
										if($i==$podesavanje['broj_postova']){
											echo "<option value='".$i."' selected>".$i."</option>";
										}else{
											echo "<option value='".$i."'>".$i."</option>";
										}
									}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="first_column">Broj pisama:</td>
					<td class="second_column">
						<select name="pisma" class="set_select">
							<?php 
								for($i=2;$i<=20;$i++){
									if($i%2==0){
										if($i==$podesavanje['broj_pisama']){
											echo "<option value='".$i."' selected>".$i."</option>";
										}else{
											echo "<option value='".$i."'>".$i."</option>";
										}
									}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="hidden" name="id_korisnika" value="<?php echo $korisnik; ?>"/></td>
				</tr>
				<tr>
					<td colspan="2" style="color:white;"><input type="submit" name="podesi" value=" " class="change_bt"/><?php echo @$ispis; ?></td>
				</tr>
			</table>
			</form>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
<?php session_start(); 
	if(!$_SESSION['uloga']=="administrator"){
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
			<div class="admin_title">Podešavanja foruma</div>
			<?php 
				include("./inc/konekcija.inc");
				
				if(isset($_POST['podesi'])){
					$logovanje=$_POST['logovanje'];
					$registracija=$_POST['registracija'];
					$broj_kategorija=$_POST['kategorije'];
					$broj_podkategorija=$_POST['podkategorije'];
					$broj_tema=$_POST['teme'];
					$broj_postova=$_POST['postovi'];
					$broj_korisnika=$_POST['korisnici'];
					$broj_pisama=$_POST['pisma'];
					
					$upit_izmena_podesavanja="UPDATE podesavanja SET logovanje='".$logovanje."',registracija='".$registracija."',broj_kategorija='".$broj_kategorija."',broj_podkategorija='".$broj_podkategorija."',broj_tema='".$broj_tema."',broj_postova='".$broj_postova."',broj_korisnika='".$broj_korisnika."',broj_pisama='".$broj_pisama."' WHERE id_podesavanja='1'";
					$rezultat_izmena_podesavanja=mysql_query($upit_izmena_podesavanja,$konekcija);
					if($rezultat_izmena_podesavanja){
						$ispis="Uspešno";
					}else{
						$ispis="Greška";
					}
				}
				
				$upit_podesavanja="SELECT * FROM podesavanja WHERE id_podesavanja='1'";
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
					<td class="first_column">Logovanje:</td>
					<td class="second_column">
						<select name="logovanje" class="set_select">
							<?php 
								if($podesavanje['logovanje']=="1"){
									echo "<option value='1' selected>Da</option>";
									echo "<option value='2'>Ne</option>";
								}else if($podesavanje['logovanje']=="2"){
									echo "<option value='1'>Da</option>";
									echo "<option value='2' selected>Ne</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="first_column">Registracija:</td>
					<td class="second_column">
						<select name="registracija" class="set_select">
							<?php 
								if($podesavanje['registracija']=="1"){
									echo "<option value='1' selected>Da</option>";
									echo "<option value='2'>Ne</option>";
								}else if($podesavanje['registracija']=="2"){
									echo "<option value='1'>Da</option>";
									echo "<option value='2' selected>Ne</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="first_column">Broj kategorija:</td>
					<td class="second_column">
						<select name="kategorije" class="set_select">
							<?php 
								for($i=3;$i<=30;$i++){
									if($i%3==0){
										if($i==$podesavanje['broj_kategorija']){
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
					<td class="first_column">Broj podkategorija:</td>
					<td class="second_column">
						<select name="podkategorije" class="set_select">
							<?php 
								for($i=3;$i<=30;$i++){
									if($i%3==0){
										if($i==$podesavanje['broj_podkategorija']){
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
					<td class="first_column">Broj korisnika:</td>
					<td class="second_column">
						<select name="korisnici" class="set_select">
							<?php 
								for($i=3;$i<=30;$i++){
									if($i%3==0){
										if($i==$podesavanje['broj_korisnika']){
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
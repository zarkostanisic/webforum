<?php session_start();
	
	include("./inc/konekcija.inc");
	$upit_podesavanja="SELECT * FROM podesavanja WHERE id_podesavanja='1'";
	$rezultat_podesavanja=mysql_query($upit_podesavanja,$konekcija);
	if($rezultat_podesavanja){
		$broj=mysql_num_rows($rezultat_podesavanja);
		if($broj==1){
			$podesavanje=mysql_fetch_array($rezultat_podesavanja);
		}
	}
	mysql_close($konekcija);
	
	if(@$_SESSION['uloga']!=""||$podesavanje['registracija']=="2"){
		header("Location:index.php");
	}
?>
<?php 
	if(isset($_POST['registruj'])){
		include("./inc/konekcija.inc");
		include("./inc/funkcije_slike.inc");
		$ime=$_POST['ime'];
		$prezime=$_POST['prezime'];
		$korisnicko_ime=strtolower($_POST['korisnicko_ime']);
		$sifra=strtolower($_POST['sifra']);
		$sifra2=strtolower($_POST['sifra2']);
		$email=strtolower($_POST['email']);
		$telefon=$_POST['telefon'];
		@$dan=$_POST['dan'];
		@$mesec=$_POST['mesec'];
		$godina=$_POST['godina'];
		$datum_rodjenja=$godina."-".$mesec."-".$dan;
		@$pol=strtolower($_POST['pol']);
		$grad=strtolower($_POST['grad']);
		$slika=$_FILES['slika'];
		$naziv_slike=$slika['name'];
		$tip_slike=$slika['type'];
		$datum_registracije=@date("Y-m-d H:i:s");
		$reg_ime="^[A-ZŽĆČĐŠ]{1,2}[a-zžćčđš]{2,19}$";
		$reg_prezime="^[A-ZŽĆČĐŠ]{1,2}[a-zžćčđš]{2,19}$";
		$reg_korisnicko_ime="^[a-z]{5,20}$";
		$reg_sifra="^[a-z0-9]{5,}$";
		$reg_sifra2="^[a-z0-9]{5,}$";
		$reg_email="^[a-z]{1,}[\.\-]{0,1}[a-z]{0,}@[a-z]{2,}[\.]{1}[a-z]{2,3}$";
		$reg_telefon="^[0-9]{8,10}$";
		$reg_grad="^[a-z]{2,20}$";
		
		$greske=array();
		
		if(!@ereg($reg_ime,$ime)){
			$greske[0]="*";
		}

		if(!@ereg($reg_prezime,$prezime)){
			$greske[1]="*";
		}
			
		if(!@ereg($reg_korisnicko_ime,$korisnicko_ime)){
			$greske[2]="*";
		}
		if(!@ereg($reg_sifra,$sifra)){
			$greske[3]="*";
		}else{
			$sifra_md5=md5(strtolower($_POST['sifra']));
		}
		
		if(!@ereg($reg_sifra2,$sifra2)){
			$greske[4]="*";
		}else{
			$sifra2_md5=md5(strtolower($_POST['sifra2']));
		}
		
		if(@$sifra_md5!=@$sifra2_md5){
			$greske[3]="*";
			$greske[4]="*";
		}
		
		if(!@ereg($reg_email,$email)){
			$greske[5]="*";
		}
		
		if(!@ereg($reg_telefon,$telefon)){
			$greske[6]="*";
		}

		
		if($dan=="0"||$mesec=="0"||$godina=="0"){
			$greske[7]="*";
		}
		if($pol==""){
			$greske[8]="*";
		}
		if(!@ereg($reg_grad,$grad)){
			$greske[9]="*";
		}
		if(strlen($tip_slike)>0){
			if(($tip_slike!="image/jpg")&&($tip_slike!="image/jpeg")&&($tip_slike!="image/png")){
				$greske[10]="Greška tip slike";
			}
		}
		
		if(count($greske)==0){
			$upit_korisnik="SELECT * FROM korisnici WHERE korisnicko_ime='$korisnicko_ime'";
			$rezultat_korisnik=mysql_query($upit_korisnik,$konekcija);
			if($rezultat_korisnik){
				$broj_korisnik=mysql_num_rows($rezultat_korisnik);
				if($broj_korisnik>0){
				$ispis_registracija="Korisnik već postoji";
				}else{
					if($tip_slike!=""){
						if(move_uploaded_file($slika['tmp_name'],"pictures/users/".$datum_rodjenja."-".$naziv_slike)){
							malaslika("pictures/users/".$datum_rodjenja."-".$naziv_slike,"pictures/users/small/".$datum_rodjenja."-".$naziv_slike,120,120);
							$upit_registracija="INSERT INTO korisnici VALUES('','2','".$ime."','".$prezime."','".$korisnicko_ime."','".$sifra_md5."','".$email."','".$telefon."','".$datum_rodjenja."','".$pol."','".$grad."','".$datum_rodjenja."-".$naziv_slike."','".$datum_registracije."')";
							$rezultat_registracija=mysql_query($upit_registracija,$konekcija);
						}
					}else{
						$upit_registracija="INSERT INTO korisnici VALUES('','2','".$ime."','".$prezime."','".$korisnicko_ime."','".$sifra_md5."','".$email."','".$telefon."','".$datum_rodjenja."','".$pol."','".$grad."','','".$datum_registracije."')";
						$rezultat_registracija=mysql_query($upit_registracija,$konekcija);
						if($rezultat_registracija){
							echo "uspesno";
						}else{
							echo "greska";
						}
					}
				}

			}
		
		}
		
		mysql_close($konekcija);
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
			<div class="registration_title">Registracija</div>
			<?php if(!@$rezultat_registracija){?>
			<table class="registration">
			<form name="registracija" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
			<tr>
				<td class="first_column">Ime:</td>
				<td class="second_column"><input type="text" name="ime" class="reg_input" value="<?php echo @$ime; ?>"/></td><td class="error"><?php echo @$greske[0]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Prezime:</td>
				<td class="second_column"><input type="text" name="prezime" class="reg_input" value="<?php echo @$prezime; ?>"/></td><td class="error"><?php echo @$greske[1]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Korisničko ime:</td>
				<td class="second_column"><input type="text" name="korisnicko_ime" class="reg_input" value="<?php echo @$korisnicko_ime; ?>"/></td><td class="error"><?php echo @$greske[2]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Šifra:</td>
				<td class="second_column"><input type="password" name="sifra" class="reg_input" /></td><td class="error"><?php echo @$greske[3]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Ponovi šifru:</td>
				<td class="second_column"><input type="password" name="sifra2" class="reg_input"/></td><td class="error"><?php echo @$greske[4]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Email:</td>
				<td class="second_column"><input type="text" name="email" class="reg_input" value="<?php echo @$email; ?>"/></td><td class="error"><?php echo @$greske[5]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Telefon:</td>
				<td class="second_column"><input type="text" name="telefon" class="reg_input" value="<?php echo @$telefon; ?>"/></td><td class="error"><?php echo @$greske[6]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Datum rođenja:</td>
				<td class="second_column">
					<?php 
						if(!isset($_POST['registruj'])){
					?>
					<div id="year" style="float:left;">
					<select id="godina" name="godina" class="reg_select" onChange="show_month();">
						<option value="0">Godina</option>
						<?php 
							for($i=2012;$i>=1910;$i--){
								echo "<option value='".$i."'>".$i."</option>";
							}
						?>
					</select>
					</div>
					<div id="month" style="float:left;">
					<select id="mesec" name="mesec" class="reg_select" onChange="show_day();" style="display:none;" >
					</select>
					</div>
					<div id="day" style="float:left;">
					<select id="dan" name="dan" class="reg_select" style="display:none;">
					</select>
					</div>
					<?php }
						else{
					?>
					<div id="year" style="float:left;">
					<select id="godina" name="godina" class="reg_select" onChange="show_month();">
						<option value="0">Godina</option>
						<?php 
							for($i=2012;$i>=1910;$i--){
								if($godina==$i){
									echo "<option value='".$i."' selected>".$i."</option>";
								}else{
									echo "<option value='".$i."'>".$i."</option>";
								}
							}
						?>
					</select>
					</div>
					<div id="month" style="float:left;">
					<select id="mesec" name="mesec" class="reg_select" onChange="show_day();">
					<?php
						$meseci=array("1"=>"Januar","2"=>"Februar","3"=>"Mart","4"=>"April","5"=>"Maj","6"=>"Jun","7"=>"Jul","8"=>"Avgust","9"=>"Septembar","10"=>"Oktobar","11"=>"Novembar","12"=>"Decembar");
						
						echo "<option value='0'>Mesec</option>";
						
						foreach ($meseci as $broj => $mesec_naziv) {
							if($mesec==$broj){
								echo "<option value='".$broj."' selected>".$mesec_naziv."</option>";
							}else{
								echo "<option value='".$broj."'>".$mesec_naziv."</option>";
							}
						}
					?>
					</select>
					</div>
					<div id="day" style="float:left;">
					<select id="dan" name="dan" class="reg_select">
					<?php
						$dani=array();
						$dani[1]=31;
						if($godina%4==0){
							$dani[2]=29;
						}else{
							$dani[2]=28;
						}
						$dani[3]=31;
						$dani[4]=30;
						$dani[5]=31;
						$dani[6]=30;
						$dani[7]=31;
						$dani[8]=31;
						$dani[9]=30;
						$dani[10]=31;
						$dani[11]=30;
						$dani[12]=31;
		
						$broj_dana=$dani[$mesec];
						echo "<option value='0'>Dan</option>";
						for($i=1;$i<=$broj_dana;$i++){
							if($dan==$i){
								echo "<option value='".$i."' selected>".$i."</option>";
							}else{
								echo "<option value='".$i."'>".$i."</option>";
							}
						}
					?>
					</select>
					</div>
					<?php 
						}
					?>
				</td>
				<td class="error"><?php echo @$greske[7]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Pol:</td>
				<td class="second_column">
					<?php 
						if(@$pol=="m"){
							echo "<input type='radio' name='pol' value='m' checked/>M";
							echo "<input type='radio' name='pol' value='z'/>Z";
						}else if(@$pol=="z"){
							echo "<input type='radio' name='pol' value='m'/>M";
							echo "<input type='radio' name='pol' value='z' checked/>Z";
						}else{
							echo "<input type='radio' name='pol' value='m'/>M";
							echo "<input type='radio' name='pol' value='z'/>Z";
						}
					?>
				</td><td class="error"><?php echo @$greske[8]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Grad:</td>
				<td class="second_column"><input type="text" name="grad" class="reg_input" value="<?php echo @$grad; ?>"/></td>
				<td class="error"><?php echo @$greske[9]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Slika:</td>
				<td class="second_column">
					<input type="file" name="slika" class="reg_input" />
					<p style="color:black;font-size:10px;">Slika nije obavezna</p>
				</td>
				<td style="color:orange;font-weight:bold;"><?php echo @$greske[10]; ?></td>
			</tr>
			<tr>
				<td colspan="3" style="color:orange;text-align:left;text-indent:20px;"><?php echo @$ispis_registracija; ?></td>
			</tr>
			<tr>
				<td></td>
				<td><input  type="submit" name="registruj" value=" " class="reg_bt" /></td>
				<td></td>
			</tr>
			</form>
			</table>
			<?php }else{
				echo "<table class='registration'>";
				echo "<tr>";
				echo "<td colspan='4' class='first_column'>Registracija uspesna.Vasi podaci za logovanje su:</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td class='first_column'>Korisnicko ime:</td>";
				echo "<td class='second_column'>".$korisnicko_ime."</td>";
				echo "<td class='first_column'>Sifra:</td>";
				echo "<td class='second_column'>".$sifra."</td>";
				echo "</tr>";
				echo "</table>";
			}?>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
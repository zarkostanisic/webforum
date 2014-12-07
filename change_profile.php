<?php session_start(); 
	@$id_korisnika=$_GET['user'];
	if(@$_POST['id_korisnika']){
		$id_korisnika=$_POST['id_korisnika'];
	}
	
	if(@$_SESSION['uloga']!="administrator"&&@$_SESSION['id_korisnika']!=$id_korisnika){
		header("Location:index.php");
	}

?>
<?php 
	include("./inc/konekcija.inc");
				
	$upit_korisnik="SELECT * FROM korisnici k JOIN uloge u ON k.id_uloge=u.id_uloge WHERE id_korisnika='".$id_korisnika."'";
	$rezultat_korisnik=mysql_query($upit_korisnik,$konekcija);
				
	if($rezultat_korisnik){
		$broj=mysql_num_rows($rezultat_korisnik);
		if($broj==1){
			$korisnik=mysql_fetch_array($rezultat_korisnik);
		}
	}
	
	if(isset($_POST['izmeni'])){
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
		if($_SESSION['uloga']=="administrator"){
			$status=$_POST['status'];
		}
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
		
		if(strlen($sifra)>0){
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
					if($_SESSION['uloga']=="administrator"){
						if($tip_slike!=""&&strlen($sifra)>0){
							if(move_uploaded_file($slika['tmp_name'],"pictures/users/".$datum_rodjenja."-".$naziv_slike)){
								@unlink("pictures/users/small/".$korisnik['slika_korisnika']);
								@unlink("pictures/users/".$korisnik['slika_korisnika']);
								malaslika("pictures/users/".$datum_rodjenja."-".$naziv_slike,"pictures/users/small/".$datum_rodjenja."-".$naziv_slike,120,120);
								$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',sifra='".$sifra_md5."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',slika_korisnika='".$datum_rodjenja."-".$naziv_slike."',id_uloge='".$status."' WHERE id_korisnika='".$id_korisnika."'";
								$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
							}
						}else if($tip_slike!=""&&strlen($sifra)==0){
							if(move_uploaded_file($slika['tmp_name'],"pictures/users/".$datum_rodjenja."-".$naziv_slike)){
								@unlink("pictures/users/small/".$korisnik['slika_korisnika']);
								@unlink("pictures/users/".$korisnik['slika_korisnika']);
								malaslika("pictures/users/".$datum_rodjenja."-".$naziv_slike,"pictures/users/small/".$datum_rodjenja."-".$naziv_slike,120,120);
								$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',slika_korisnika='".$datum_rodjenja."-".$naziv_slike."',id_uloge='".$status."' WHERE id_korisnika='".$id_korisnika."'";
								$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
							}
						}else if($tip_slike==""&&strlen($sifra)>0){
							$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',sifra='".$sifra_md5."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',id_uloge='".$status."' WHERE id_korisnika='".$id_korisnika."'";
							$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
						}else{
							$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',id_uloge='".$status."' WHERE id_korisnika='".$id_korisnika."'";
							$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
						}
					}else{
						if($tip_slike!=""&&strlen($sifra)>0){
							if(move_uploaded_file($slika['tmp_name'],"pictures/users/".$datum_rodjenja."-".$naziv_slike)){
								@unlink("pictures/users/small/".$korisnik['slika_korisnika']);
								@unlink("pictures/users/".$korisnik['slika_korisnika']);
								malaslika("pictures/users/".$datum_rodjenja."-".$naziv_slike,"pictures/users/small/".$datum_rodjenja."-".$naziv_slike,120,120);
								$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',sifra='".$sifra_md5."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',slika_korisnika='".$datum_rodjenja."-".$naziv_slike."' WHERE id_korisnika='".$id_korisnika."'";
								$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
							}
						}else if($tip_slike!=""&&strlen($sifra)==0){
							if(move_uploaded_file($slika['tmp_name'],"pictures/users/".$datum_rodjenja."-".$naziv_slike)){
								@unlink("pictures/users/small/".$korisnik['slika_korisnika']);
								@unlink("pictures/users/".$korisnik['slika_korisnika']);
								malaslika("pictures/users/".$datum_rodjenja."-".$naziv_slike,"pictures/users/small/".$datum_rodjenja."-".$naziv_slike,120,120);
								$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',slika_korisnika='".$datum_rodjenja."-".$naziv_slike."' WHERE id_korisnika='".$id_korisnika."'";
								$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
							}
						}else if($tip_slike==""&&strlen($sifra)>0){
							$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',sifra='".$sifra_md5."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."' WHERE id_korisnika='".$id_korisnika."'";
							$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
						}else{
							$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."' WHERE id_korisnika='".$id_korisnika."'";
							$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
						}
					}
				}else{
					if($_SESSION['uloga']=="administrator"){
						if($tip_slike!=""&&strlen($sifra)>0){
							if(move_uploaded_file($slika['tmp_name'],"pictures/users/".$datum_rodjenja."-".$naziv_slike)){
								@unlink("pictures/users/small/".$korisnik['slika_korisnika']);
								@unlink("pictures/users/".$korisnik['slika_korisnika']);
								malaslika("pictures/users/".$datum_rodjenja."-".$naziv_slike,"pictures/users/small/".$datum_rodjenja."-".$naziv_slike,120,120);
								$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',korisnicko_ime='".$korisnicko_ime."',sifra='".$sifra_md5."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',slika_korisnika='".$datum_rodjenja."-".$naziv_slike."',id_uloge='".$status."' WHERE id_korisnika='".$id_korisnika."'";
								$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
							}
						}else if($tip_slike!=""&&strlen($sifra)==0){
							if(move_uploaded_file($slika['tmp_name'],"pictures/users/".$datum_rodjenja."-".$naziv_slike)){
								@unlink("pictures/users/small/".$korisnik['slika_korisnika']);
								@unlink("pictures/users/".$korisnik['slika_korisnika']);
								malaslika("pictures/users/".$datum_rodjenja."-".$naziv_slike,"pictures/users/small/".$datum_rodjenja."-".$naziv_slike,120,120);
								$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',korisnicko_ime='".$korisnicko_ime."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',slika_korisnika='".$datum_rodjenja."-".$naziv_slike."',id_uloge='".$status."' WHERE id_korisnika='".$id_korisnika."'";
								$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
							}
						}else if($tip_slike==""&&strlen($sifra)>0){
							$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',korisnicko_ime='".$korisnicko_ime."',sifra='".$sifra_md5."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',id_uloge='".$status."' WHERE id_korisnika='".$id_korisnika."'";
							$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
						}else{
							$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',korisnicko_ime='".$korisnicko_ime."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',id_uloge='".$status."' WHERE id_korisnika='".$id_korisnika."'";
							$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
						}
					}else{
						if($tip_slike!=""&&strlen($sifra)>0){
							if(move_uploaded_file($slika['tmp_name'],"pictures/users/".$datum_rodjenja."-".$naziv_slike)){
								@unlink("pictures/users/small/".$korisnik['slika_korisnika']);
								@unlink("pictures/users/".$korisnik['slika_korisnika']);
								malaslika("pictures/users/".$datum_rodjenja."-".$naziv_slike,"pictures/users/small/".$datum_rodjenja."-".$naziv_slike,120,120);
								$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',korisnicko_ime='".$korisnicko_ime."',sifra='".$sifra_md5."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',slika_korisnika='".$datum_rodjenja."-".$naziv_slike."',id_uloge='".$status."' WHERE id_korisnika='".$id_korisnika."'";
								$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
							}
						}else if($tip_slike!=""&&strlen($sifra)==0){
							if(move_uploaded_file($slika['tmp_name'],"pictures/users/".$datum_rodjenja."-".$naziv_slike)){
								@unlink("pictures/users/small/".$korisnik['slika_korisnika']);
								@unlink("pictures/users/".$korisnik['slika_korisnika']);
								malaslika("pictures/users/".$datum_rodjenja."-".$naziv_slike,"pictures/users/small/".$datum_rodjenja."-".$naziv_slike,120,120);
								$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',korisnicko_ime='".$korisnicko_ime."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."',slika_korisnika='".$datum_rodjenja."-".$naziv_slike."' WHERE id_korisnika='".$id_korisnika."'";
								$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
							}
						}else if($tip_slike==""&&strlen($sifra)>0){
							$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',korisnicko_ime='".$korisnicko_ime."',sifra='".$sifra_md5."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."' WHERE id_korisnika='".$id_korisnika."'";
							$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
						}else{
							$upit_izmena="UPDATE korisnici SET ime='".$ime."',prezime='".$prezime."',korisnicko_ime='".$korisnicko_ime."',email='".$email."',telefon='".$telefon."',datum_rodjenja='".$datum_rodjenja."',pol='".$pol."',grad='".$grad."' WHERE id_korisnika='".$id_korisnika."'";
							$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
						}
					}
				}

			}
		
		}
		
	}
	
	$upit_korisnik="SELECT * FROM korisnici k JOIN uloge u ON k.id_uloge=u.id_uloge WHERE id_korisnika='".$id_korisnika."'";
	$rezultat_korisnik=mysql_query($upit_korisnik,$konekcija);
				
	if($rezultat_korisnik){
		$broj=mysql_num_rows($rezultat_korisnik);
		if($broj==1){
			$korisnik=mysql_fetch_array($rezultat_korisnik);
		}
	}
	mysql_close($konekcija);
?>
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
			<table class="registration">
			<form name="izmena" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
			<?php
				echo "<tr>";
				echo "<td class='second_column' colspan='2' style='text-align:center;'>".$korisnik['korisnicko_ime']."</td>";
				echo "</tr>";
				echo "<tr>";
				if($korisnik['slika_korisnika']!=""){
					echo "<td class='first_column' colspan='2' style='text-align:center;'><a href='pictures/users/".$korisnik['slika_korisnika']."' class='slika'><img src='pictures/users/small/".$korisnik['slika_korisnika']."' alt='".$korisnik['korisnicko_ime']."'/></a></td>";
				}else{
					echo "<td class='first_column' colspan='2' style='text-align:center;'><img src='pictures/users/small/default.png' alt='".$korisnik['korisnicko_ime']."'/></td>";
				}
				echo "</tr>";
			?>
			<tr>
				<td class="first_column">Ime:</td>
				<td class="second_column"><input type="text" name="ime" class="reg_input" value="<?php echo $korisnik['ime']; ?>"/></td><td class="error"><?php echo @$greske[0]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Prezime:</td>
				<td class="second_column"><input type="text" name="prezime" class="reg_input" value="<?php echo $korisnik['prezime']; ?>"/></td><td class="error"><?php echo @$greske[1]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Korisničko ime:</td>
				<td class="second_column"><input type="text" name="korisnicko_ime" class="reg_input" value="<?php echo $korisnik['korisnicko_ime']; ?>"/></td><td class="error"><?php echo @$greske[2]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Šifra:</td>
				<td class="second_column">
					<input type="password" name="sifra" class="reg_input"/><br/>
					<p style="color:black;font-size:10px;">Unesite novu sifru ako zelite da izmenite staru</p>
				</td>
				<td class="error"><?php echo @$greske[3]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Ponovi šifru:</td>
				<td class="second_column"><input type="password" name="sifra2" class="reg_input"/></td><td class="error"><?php echo @$greske[4]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Email:</td>
				<td class="second_column"><input type="text" name="email" class="reg_input" value="<?php echo $korisnik['email']; ?>"/></td><td class="error"><?php echo @$greske[5]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Telefon:</td>
				<td class="second_column"><input type="text" name="telefon" class="reg_input" value="<?php echo $korisnik['telefon']; ?>"/></td><td class="error"><?php echo @$greske[6]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Datum rođenja:</td>
				<td class="second_column">
					<div id="year" style="float:left;">
					<select id="godina" name="godina" class="reg_select" onChange="show_month();">
						<option value="0">Godina</option>
						<?php
							$godina_ko=substr($korisnik['datum_rodjenja'],0,4);
							for($i=2012;$i>=1910;$i--){
								if($godina_ko==$i){
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
						
						$mesec_ko=substr($korisnik['datum_rodjenja'],5,2);
						
						foreach ($meseci as $broj => $mesec_naziv) {
							if($mesec_ko==$broj){
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
						$dani["01"]=31;
						if($godina_ko%4==0){
							$dani["02"]=29;
						}else{
							$dani["02"]=28;
						}
						$dani["03"]=31;
						$dani["04"]=30;
						$dani["05"]=31;
						$dani["06"]=30;
						$dani["07"]=31;
						$dani["08"]=31;
						$dani["09"]=30;
						$dani["10"]=31;
						$dani["11"]=30;
						$dani["12"]=31;
						$broj_dana=$dani[$mesec_ko];
						echo "<option value='0'>Dan</option>";
						
						$dan_ko=substr($korisnik['datum_rodjenja'],8,2);
						
						for($i=1;$i<=$broj_dana;$i++){
							if($dan_ko==$i){
								echo "<option value='0".$i."' selected>".$i."</option>";
							}else{
								echo "<option value='0".$i."'>".$i."</option>";
							}
						}
					?>
					</select>
					</div>
				</td>
				<td class="error"><?php echo @$greske[7]; ?></td>
			</tr>
			<tr>
				<td class="first_column">Pol:</td>
				<td class="second_column">
					<?php 
						if($korisnik['pol']=="m"){
							echo "<input type='radio' name='pol' value='m' checked/>M";
							echo "<input type='radio' name='pol' value='z'/>Z";
						}else if($korisnik['pol']=="z"){
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
				<td class="second_column"><input type="text" name="grad" class="reg_input" value="<?php echo strtoupper(substr($korisnik['grad'],0,1)).strtolower(substr($korisnik['grad'],1)); ?>"/></td>
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
				<?php
					if($_SESSION['uloga']=="administrator"){
						include("./inc/konekcija.inc");
						$upit_uloge="SELECT * FROM uloge";
						$rezultat_uloge=mysql_query($upit_uloge,$konekcija);
						if($rezultat_uloge){
							$broj=mysql_num_rows($rezultat_uloge);
							if($broj>0){
								echo "<tr>";
								echo "<td class='first_column'>Status:</td>";
								echo "<td class='second_column'>";
								echo "<select name='status' class='add_select'>";
								while($uloga=mysql_fetch_array($rezultat_uloge)){
									if($korisnik['id_uloge']==$uloga['id_uloge']){
										echo "<option value='".$uloga['id_uloge']."' selected>".$uloga['naziv_uloge']."</option>";
									}else{
										echo "<option value='".$uloga['id_uloge']."'>".$uloga['naziv_uloge']."</option>";
									}
								}
								echo "</select>";
								echo "</td>";
								echo "<td style='color:orange;font-weight:bold;'></td>";
								echo "</tr>"; 

							}
						}
						mysql_close($konekcija);
					}
				?>
			<tr>
				<td colspan="3" style="color:orange;text-align:left;text-indent:20px;"><?php echo @$ispis_registracija; ?></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id_korisnika" value="<?php echo $korisnik['id_korisnika']; ?>"/></td>
				<td><input  type="submit" name="izmeni" value=" " class="change_bt" /></td>
				<td></td>
			</tr>
			</form>
			</table>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
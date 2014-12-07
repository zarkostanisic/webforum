<?php session_start(); 
	if(@$_SESSION['uloga']!=""){
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
			<div class="admin_title">Kontakt</div>
			<table class="registration">
			<form name="kontakt" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<tr>
				<td class="first_column">Vaše ime:</td>
				<td class="second_column"><input type="text" name='ime' class="reg_input" style="width:200px;"/></td>
			</tr>
			<tr>
				<td class="first_column">Vaš e-mail:</td>
				<td class="second_column"><input type="text" name='email' class="reg_input" style="width:200px;"/></td>
			</tr>
			<tr>
				<td class="first_column">Vaša poruka:</td>
				<td class="second_column"><textarea name='poruka' style="width:200px;"></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="posalji" value=" " class="sent_bt" style="float:left;"/>
					<input type="reset" name="reset" value=" " class="delete" style="float:left;margin-left:5px;margin-top:-0.5px;"/>
				</td>
			</tr>
			</form>
			<?php
				if(isset($_POST['posalji'])){

					$ime=$_POST['ime'];
					$email=$_POST['email'];
					$poruka=$_POST['poruka'];
					$nas_email='ipanamai@gmail.com';
					$subject = 'Poruka sa sajta!';
					$message = 'Ime: '.$ime.'\n \n'.$poruka;
					$headers = 'From: '.$email . "\r\n" .
					'Reply-To: '.$email. "\r\n" .
					'X-Mailer: PHP/' . phpversion();;
					ini_set("SMTP", "mail.webforum.netai.net");
					ini_set("sendmail_from", $email);
					ini_set("smtp_port", "25");
					$mail="/^[A-z0-9\._-]+". "@". "[A-z0-9][A-z0-9-]*". "(\.[A-z0-9_-]+)*". "\.([A-z]{2,6})$/";
					if(!preg_match("/^[A-z]{3,}$/", $ime)){
						echo "<td colspan='2' class='first_column'>Ime mora da sadrži slova i više od 3 karaktera.</td>";
					}
					elseif(!preg_match($mail, $email)){
						echo "<td colspan='2' class='first_column'>Nepravilno unet e-mail. Unesite ispravan e-mail.</td>";
					}
					elseif(!preg_match("/^[A-z0-9\._-\s]{20,}$/", $poruka)){
						echo "<td colspan='2' class='first_column'>Poruka mora da sadrži izmedju 20 i 2 000 karaktera!</td>";
					}
					elseif(@mail($nas_email ,$subject ,$message ,$headers )){
						echo "<td colspan='2' class='first_column'>E-mail je poslat</td>";
					}
					else{echo"<td colspan='2' class='first_column'>Neuspelo slanje email-a</td>";}
				}
			?>
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
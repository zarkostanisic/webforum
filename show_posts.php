<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
		include("./inc/head.inc");
	?>
</head>
<body onLoad="show_posts(<?php echo $_GET['thema']; ?>);">
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
				$id_teme=$_GET['thema'];
				
				$upit_teme="SELECT * FROM teme WHERE id_teme='".$id_teme."'";
				$rezultat_teme=mysql_query($upit_teme,$konekcija);
				if($rezultat_teme){
					$broj=mysql_num_rows($rezultat_teme);
					if($broj==1){
						$tema=mysql_fetch_array($rezultat_teme);
					}
				}
				echo "<div class='post_title'></div>";
				if(isset($_SESSION['uloga'])&&$tema['status']==1){
					echo "<div class='admin_form' id='admin_form'>";
					echo "<table>";
					echo "<form name='dodaj_post'>";
					echo "<tr>";
					echo "<td>Odgovor:</td>";
					echo "<td><textarea class='theme_textarea' id='odgovor'></textarea></td>";
					echo "<td><input type='button' id='dodaj' class='add_bt' onClick='user_add_post();'/></td>";
					echo "<td><input type='hidden' id='tema' value='".$id_teme."' /></td>";
					echo "<td id='query_input'></td>";
					echo "<td id='funkcija'></td>";
					echo "</tr>";
					echo "</form>";
					echo "</table>";
					echo "</div>";
					echo "<div class='admin_title_bottom'></div>";
				}else{
					echo "<form name='dodaj_post'>";
					echo "<div><input type='hidden' id='tema' value='".$id_teme."' /></div>";
					echo "<div id='query_input'></div>";
					echo "<div id='funkcija'></div>";
					echo "</form>";
				}
				mysql_close($konekcija);
			?>
			<div id="show_posts"></div>
		</div>
		<div id="footer">
			<?php 
				include("./inc/footer.inc");
			?>
		</div>
	</div>
</body>
</html>
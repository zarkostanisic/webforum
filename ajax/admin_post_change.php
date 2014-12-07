<?php 
	include("../inc/konekcija.inc");
	
	$id_posta=$_POST['post_id'];
	$post=$_POST['post'];
	$upit_izmena="UPDATE postovi SET post='".$post."' WHERE id_posta='".$id_posta."'";
	$rezultat_izmena=mysql_query($upit_izmena,$konekcija);
	if($rezultat_izmena){
		$upit_postovi="SELECT * FROM postovi WHERE id_posta='".$id_posta."'";
		$rezultat_postovi=mysql_query($upit_postovi,$konekcija);
		if($rezultat_postovi){
			$broj=mysql_num_rows($rezultat_postovi);
			if($broj==1){
				$post=mysql_fetch_array($rezultat_postovi);
				echo "<div class='admin_title'>Izmeni post</div>";
				echo "<div class='admin_form'>";
				echo "<form name='izmena_kategorije'>";
				echo "<table>";
				echo "<tr>";
				echo "<td>Odgovor:</td>";
				echo "<td><textarea class='admin_textarea' id='odgovor'>".$post['post']."</textarea></td>";
				echo "<td><input type='hidden' id='id_odgovora' value='".$post['id_posta']."'/></td>";
				echo "<td><input type='button' value=' ' onClick='change_post();' class='change_bt'/></td>";
				echo "<td>Uspešno</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				echo "</div>";
			}
		}
	}else{
		$upit_postovi="SELECT * FROM postovi WHERE id_posta='".$id_posta."'";
		$rezultat_postovi=mysql_query($upit_postovi,$konekcija);
		if($rezultat_postovi){
			$broj=mysql_num_rows($rezultat_postovi);
			if($broj==1){
				$post=mysql_fetch_array($rezultat_postovi);
				echo "<div class='admin_title'>Izmeni post</div>";
				echo "<div class='admin_form'>";
				echo "<form name='izmena_kategorije'>";
				echo "<table>";
				echo "<tr>";
				echo "<td>Odgovor:</td>";
				echo "<td><textarea class='admin_textarea' id='odgovor'>".$post['post']."</textarea></td>";
				echo "<td><input type='hidden' id='id_odgovora' value='".$post['id_posta']."'/></td>";
				echo "<td><input type='button' value=' ' onClick='change_post();' class='change_bt'/></td>";
				echo "<td>Greška</td>";
				echo "</tr>";
				echo "</table>";
				echo "</form>";
				echo "</div>";
			}
		}
	}
	
	mysql_close($konekcija);
?>
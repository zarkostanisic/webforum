<?php 
	if(strstr($_SERVER['PHP_SELF'],"show_themes.php")){
?>
<div id="footer_left">
	<img src="images/open.png"/>
	<p>Otvorena</p>
	<img src="images/lock.png"/>
	<p>Zatvorena</p>
</div>
<?php 
	}else if(strstr($_SERVER['PHP_SELF'],"index.php")){
?>
<div id="footer_left">
	<img src="images/open.png"/>
	<p>Otvoren</p>
	<img src="images/lock.png"/>
	<p>Zatvoren</p>
</div>
<?php 
	}else{
		echo "<p>&copy;&reg; Zarko Stanisic </p>";
	}
?>
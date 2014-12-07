<?php 
	function prints_year(){
		for($i=2012;$i>=1910;$i--){
			echo "<option value='".$i."'>".$i."</option>";
		}
	}
?>
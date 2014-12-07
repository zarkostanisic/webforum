<?php 
	$meseci=array("1"=>"Januar","2"=>"Februar","3"=>"Mart","4"=>"April","5"=>"Maj","6"=>"Jun","7"=>"Jul","8"=>"Avgust","9"=>"Septembar","10"=>"Oktobar","11"=>"Novembar","12"=>"Decembar");
	$godina=$_GET['year'];
	if($godina!=0){
		echo "<option value='0'>Mesec</option>";
		foreach ($meseci as $broj => $mesec) {
			echo "<option value='".$broj."'>".$mesec."</option>";
		}
	}
?>
<?php
	$godina=$_GET['year'];
	$mesec=$_GET['month'];
	if($mesec!="0"&&$godina!="0"){
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
			echo "<option value='".$i."'>".$i."</option>";
		}
	}
	
?>
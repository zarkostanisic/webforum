<?php 
	@$konekcija=mysql_connect("mysql13.000webhost.com","a5706154_forum","8panama8");
	if(!$konekcija){
		echo "Greška prilikom uspostavljanja konekcije sa serverom";
	}else{
		@$baza=mysql_select_db("a5706154_forum",$konekcija);
		if(!$baza){
			echo "Greška prilikom selektovanja baze";
		}else{
			mysql_set_charset("utf8",$konekcija);
		}
	}
?>
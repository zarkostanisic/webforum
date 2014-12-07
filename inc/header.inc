<a href="index.php"><img src="./images/logo.png"/></a>
<div id="search_form">
<form name="pretraga" action="index.php" method="post">
<table>
<tr>
	<td>Naziv:</td>
	<td><input type="text" id="naziv" class="search_input"/></td>
</tr>
<tr>
	<td>Po čemu:</td>
	<td>
		<select id="izaberi" class="search_select">
			<option value="0">Izaberi</option>
			<option value="1">Teme</option>
			<option value="2">Korisnici</option>
		</select>
	</td>
</tr>
<tr>
	<td></td>
	<td><input type="button" name="pretrazi" value=" " class="search_bt" onClick="return search();"/></td>
</tr>
</table>
</form>
</div>
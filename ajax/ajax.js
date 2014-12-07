function getHTTPObject(){
	if (window.ActiveXObject){
		return new ActiveXObject("Microsoft.XMLHTTP");
	}else if(window.XMLHttpRequest){
		return new XMLHttpRequest();
	}else {
		alert("Your browser does not support AJAX.");
		return null;
	}
}

/*---Loading---*/

/*--Show category--*/

function show_cat(){
	if(httpObject.readyState == 4){
		document.getElementById('center_content').innerHTML = httpObject.responseText;
		online();
	}
}

function show_category(){
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/show_category.php", true);
		httpObject.send(null);
		httpObject.onreadystatechange = show_cat;
	}
}

/*--Show online--*/

function show_onl(){
	if(httpObject.readyState == 4){
		document.getElementById('center_content').innerHTML = httpObject.responseText;
		online();
	}
}

function show_online(){
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/show_online.php", true);
		httpObject.send(null);
		httpObject.onreadystatechange = show_onl;
	}
}

/*--Show themes--*/

function show_the(){
	if(httpObject.readyState == 4){
		document.getElementById('show_themes').innerHTML = httpObject.responseText;
		online();
	}
}

function show_themes(a,b){
	if(b==0){
		document.getElementById('s').value=0;
	}
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/show_themes.php?subcategory=" + a + "&s=" + s, true);
		httpObject.send(null);
		httpObject.onreadystatechange = show_the;
	}
}

function user_add_the(){
	if(httpObject.readyState == 4){
		document.getElementById('query_input').innerHTML = httpObject.responseText;
		show_themes(document.getElementById('podkategorija').value,0);
		document.getElementById('naziv_teme').value="";
		document.getElementById('pitanje').value="";
	}
}

function user_add_theme(){
	var theme_name=document.getElementById('naziv_teme').value;
	var subcategory_id=document.getElementById('podkategorija').value;
	var question=document.getElementById('pitanje').value;
	reg_theme_name=/^[A-ZŽĆČĐŠ]{1,2}[a-zžćčđš0-9\-\s]{2,28}$/;
	reg_question=/^[A-ZŽĆČĐŠ]{1,2}[A-Za-zžćčđšŽĆČĐŠ\s\.\,\?\!\-0-9]{1,998}$/;

	if(subcategory_id=="0"){
		alert("Morate izabrati podkategoriju");
	}else if(!(reg_theme_name.test(theme_name))){
		alert("Greška naziv teme");
	}else if(!(reg_question.test(question))){
		alert("Greška pitanje");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("POST","./ajax/admin_theme_add.php",true);
			httpObject.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			httpObject.send("theme_name=" + theme_name + "&subcategory_id=" + subcategory_id + "&question=" + question);
			httpObject.onreadystatechange = user_add_the;
		}
	}

}

/*--Show posts--*/

function show_pos(){
	if(httpObject.readyState == 4){
		document.getElementById('show_posts').innerHTML = httpObject.responseText;
		online();
	}
}

function show_posts(a,b){
	if(b==0){
		document.getElementById('s').value=0;
	}
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}

	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/show_posts.php?thema=" + a + "&s=" + s , true);
		httpObject.send(null);
		httpObject.onreadystatechange = show_pos;
	}
}

function user_add_po(){
	if(httpObject.readyState == 4){
		document.getElementById('query_input').innerHTML = httpObject.responseText;
		show_posts(document.getElementById('tema').value,0);
		document.getElementById('odgovor').value="";
	}
}

function user_add_post(){
	var post=document.getElementById('odgovor').value;
	var theme_id=document.getElementById('tema').value;
	reg_post=/^[A-ZŽĆČĐŠ]{1,2}[A-Za-zžćčđšŽĆČĐŠ\s\.\,\?\!\-0-9]{1,998}$/;

	if(!(reg_post.test(post))){
		alert("Greška sadržaj odgovora");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("POST","./ajax/user_post_add.php",true);
			httpObject.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			httpObject.send("post=" + post + "&theme_id=" + theme_id);
			httpObject.onreadystatechange = user_add_po;
		}
	}

}

/*--Online--*/

function onl(){
	if(httpObject.readyState == 4){
		document.getElementById('online').innerHTML = httpObject.responseText;
		login_form();
	}
}

function online(){
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/online.php", true);
		httpObject.send(null);
		httpObject.onreadystatechange = onl;
	}
}

/*--Login form--*/

function login_fo(){
	if(httpObject.readyState == 4){
		document.getElementById('login_form').innerHTML = httpObject.responseText;
		menu();
	}
}

function login_form(){
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/login_form.php", true);
		httpObject.send(null);
		httpObject.onreadystatechange = login_fo;
	}
}

/*--Login--*/

function log(){
	if(httpObject.readyState == 4){
		online();
		location.reload();
	}
}

function login(){
	var username=document.getElementById('korisnicko_ime').value;
	var password=document.getElementById('sifra').value;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/login.php?username=" + username + "&password=" + password, true);
		httpObject.send(null);
		httpObject.onreadystatechange = log;
	}
}

/*--Menu--*/

function me(){
	if(httpObject.readyState == 4){
		document.getElementById('menu').innerHTML = httpObject.responseText;
	}
}

function menu(){
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/menu.php", true);
		httpObject.send(null);
		httpObject.onreadystatechange = me;
	}
}

/*--Pagging--*/

/*Pagging - next*/
function ne(){
	if(httpObject.readyState == 4){
		document.getElementById('stranicenje').innerHTML = httpObject.responseText;
		var izvrsi=document.getElementById('izvrsi').value;
		if(izvrsi=="admin_category_show"){
			admin_category_show();
		}else if(izvrsi=="admin_subcategory_show"){
			admin_subcategory_show();
		}else if(izvrsi=="admin_theme_show"){
			admin_theme_show();
		}else if(izvrsi=="show_posts"){
			show_posts(document.getElementById('tema').value);
		}else if(izvrsi=="show_themes"){
			show_themes(document.getElementById('podkategorija').value);
		}else if(izvrsi=="admin_user_show"){
			admin_user_show();
		}else if(izvrsi=="show_read_messages"){
			show_read_messages(document.getElementById('korisnik').value);
		}else if(izvrsi=="show_sent_messages"){
			show_sent_messages(document.getElementById('korisnik').value);
		}else if(izvrsi=="show_new_messages"){
			show_new_messages(document.getElementById('korisnik').value);
		}else if(izvrsi=="admin_message_show"){
			admin_message_show();
		}
	}
}

function next(a){
	var right=document.getElementById('right').value;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/next.php?right=" + right, true);
		httpObject.send(null);
		httpObject.onreadystatechange = ne;
	}
	document.getElementById('funkcija').innerHTML = "<input type='hidden' id='izvrsi' value='" + a + "'/>";
}

/*Pagging - back*/

function ba(){
	if(httpObject.readyState == 4){
		document.getElementById('stranicenje').innerHTML = httpObject.responseText;
		var izvrsi=document.getElementById('izvrsi').value;
		if(izvrsi=="admin_category_show"){
			admin_category_show();
		}else if(izvrsi=="admin_subcategory_show"){
			admin_subcategory_show();
		}else if(izvrsi=="admin_theme_show"){
			admin_theme_show();
		}else if(izvrsi=="show_posts"){
			show_posts(document.getElementById('tema').value);
		}else if(izvrsi=="show_themes"){
			show_themes(document.getElementById('podkategorija').value);
		}else if(izvrsi=="admin_user_show"){
			admin_user_show();
		}else if(izvrsi=="show_read_messages"){
			show_read_messages(document.getElementById('korisnik').value);
		}else if(izvrsi=="show_sent_messages"){
			show_sent_messages(document.getElementById('korisnik').value);
		}else if(izvrsi=="show_new_messages"){
			show_new_messages(document.getElementById('korisnik').value);
		}else if(izvrsi=="admin_message_show"){
			admin_message_show();
		}
	}
}

function back(a){
	var left=document.getElementById('left').value;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/back.php?left=" + left, true);
		httpObject.send(null);
		httpObject.onreadystatechange = ba;
	}
	document.getElementById('funkcija').innerHTML = "<input type='hidden' id='izvrsi' value='" + a + "'/>";
}

/*---Administration----*/

/*--Category--*/

/*-Category show-*/

function admin_cat(){
	if(httpObject.readyState == 4){
		document.getElementById('admin_category_print').innerHTML = httpObject.responseText;
		online();
	}
}

function admin_category_show(){
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_category_show.php?s=" + s, true);
		httpObject.send(null);
		httpObject.onreadystatechange = admin_cat;
	}
}

/*-Add category-*/

function add_cat(){
	if(httpObject.readyState == 4){
		document.getElementById('query_print').innerHTML = httpObject.responseText;
		admin_category_show();
		document.getElementById('naziv_kategorije').value="";
	}
}

function add_category(){
	var name_category=document.getElementById('naziv_kategorije').value;
	reg_name_category=/^[A-ZŽĆČĐŠ]{1,2}[a-zžćčđš0-9\-\s]{2,28}$/;
	if(!(reg_name_category.test(name_category))){
		alert("Greška naziv kategorije");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("GET", "./ajax/admin_category_add.php?name_category=" + name_category, true);
			httpObject.send(null);
			httpObject.onreadystatechange = add_cat;
		}
	}

}

/*-Delete category-*/

function delete_cat(){
	if(httpObject.readyState == 4){
		admin_category_show();
		document.getElementById('query_print').innerHTML = "";
	}
}

function delete_category(a){
	var category=a.id;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_category_delete.php?category=" + category, true);
		httpObject.send(null);
		httpObject.onreadystatechange = delete_cat;
	}
}

/*-Change category-*/

function change_cat(){
	if(httpObject.readyState == 4){
			document.getElementById('center_content').innerHTML = httpObject.responseText;
	}
}

function change_category(){
	var category_id=document.getElementById('id_kategorije').value;
	var category_name=document.getElementById('naziv_kategorije').value;
	reg_category_name=/^[A-ZŽĆČĐŠ]{1,2}[a-zžćčđš0-9\-\s]{2,28}$/;
	if(!(reg_category_name.test(category_name))){
		alert("Greška naziv kategorije");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("GET", "./ajax/admin_category_change.php?category_id=" + category_id + "&category_name=" + category_name, true);
			httpObject.send(null);
			httpObject.onreadystatechange = change_cat;
		}
	}
}

/*--Subcategory--*/

/*-Subategory show-*/

function admin_subcat(){
	if(httpObject.readyState == 4){
		document.getElementById('admin_subcategory_print').innerHTML = httpObject.responseText;
		online();
	}
}

function admin_subcategory_show(a){
	if(a==0){
		document.getElementById('s').value=0;
	}
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}
	var category_id=document.getElementById('kategorija').value;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_subcategory_show.php?category_id=" + category_id + "&s=" + s, true);
		httpObject.send(null);
		httpObject.onreadystatechange = admin_subcat;
	}
}

/*-Add subcategory-*/

function add_subcat(){
	if(httpObject.readyState == 4){
		document.getElementById('query_input').innerHTML = httpObject.responseText;
		admin_subcategory_show();
		document.getElementById('naziv_podkategorije').value="";
	}
}

function add_subcategory(){
	var subcategory_name=document.getElementById('naziv_podkategorije').value;
	var category_id=document.getElementById('kategorija').value;
	reg_subcategory_name=/^[A-ZŽĆČĐŠ]{1,2}[a-zžćčđš0-9\-\s]{2,28}$/;
	if(category_id=="0"){
		alert("Morate izabrati kategoriju");
	}else if(!(reg_subcategory_name.test(subcategory_name))){
		alert("Greška naziv podkategorije");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("GET", "./ajax/admin_subcategory_add.php?subcategory_name=" + subcategory_name + "&category_id=" + category_id, true);
			httpObject.send(null);
			httpObject.onreadystatechange = add_subcat;
		}
	}

}

/*-Delete subcategory-*/

function delete_subcat(){
	if(httpObject.readyState == 4){
		admin_subcategory_show();
		document.getElementById('query_input').innerHTML = "";
	}
}

function delete_subcategory(a){
	var subcategory=a.id;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_subcategory_delete.php?subcategory=" + subcategory, true);
		httpObject.send(null);
		httpObject.onreadystatechange = delete_subcat;
	}
}

/*-Change subcategory-*/

function change_subcat(){
	if(httpObject.readyState == 4){
			document.getElementById('center_content').innerHTML = httpObject.responseText;
	}
}

function change_subcategory(){
	var subcategory_id=document.getElementById('id_podkategorije').value;
	var subcategory_name=document.getElementById('naziv_podkategorije').value;
	var category_id=document.getElementById('kategorija').value;
	reg_subcategory_name=/^[A-ZŽĆČĐŠ]{1,2}[a-zžćčđš0-9\-\s]{2,28}$/;
	if(!(reg_subcategory_name.test(subcategory_name))){
		alert("Greška naziv kategorije");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("GET", "./ajax/admin_subcategory_change.php?subcategory_id=" + subcategory_id + "&subcategory_name=" + subcategory_name + "&category_id=" + category_id, true);
			httpObject.send(null);
			httpObject.onreadystatechange = change_subcat;
		}
	}
}

/*Lock subcategory*/

function lock_subcat(){
	if(httpObject.readyState == 4){
			show_category();
	}
}

function lock_subcategory(a){
	var status="2";
	var subcategory_id=a.name;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_lock_subcategory.php?subcategory_id=" + subcategory_id + "&status=" + status, true);
		httpObject.send(null);
		httpObject.onreadystatechange = lock_subcat;
	}
}

/*Open subcategory*/

function open_subcat(){
	if(httpObject.readyState == 4){
			show_category();
	}
}

function open_subcategory(a){
	var status="1";
	var subcategory_id=a.name;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_open_subcategory.php?subcategory_id=" + subcategory_id + "&status=" + status, true);
		httpObject.send(null);
		httpObject.onreadystatechange = open_subcat;
	}
}

/*--Themes--*/
/*-Themes show-*/

function admin_the(){
	if(httpObject.readyState == 4){
		document.getElementById('admin_theme_print').innerHTML = httpObject.responseText;
		online();
	}
}

function admin_theme_show(a){
	if(document.getElementById('kategorija')){
		var category_id=document.getElementById('kategorija').value;
	}

	if(document.getElementById('podkategorija')){
		var subcategory_id=document.getElementById('podkategorija').value;
	}

	if(a==0){
		document.getElementById('s').value=0;
	}
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}

	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_theme_show.php?category_id=" + category_id + "&subcategory_id=" + subcategory_id + "&s=" + s, true);
		httpObject.send(null);
		httpObject.onreadystatechange = admin_the;
	}
}

function admin_the_select(){
	if(httpObject.readyState == 4){
		document.getElementById('admin_form').innerHTML = httpObject.responseText;
		admin_theme_show();
	}
}

function admin_theme_show_select(a){
	if(a==0){
		document.getElementById('s').value=0;
	}
	var category_id=document.getElementById('kategorija').value;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_theme_show_select.php?category_id=" + category_id, true);
		httpObject.send(null);
		httpObject.onreadystatechange = admin_the_select;
	}
}

function admin_chg_select(){
	if(httpObject.readyState == 4){
		document.getElementById('admin_the_change_select').innerHTML = httpObject.responseText;
	}
}

function admin_theme_change_select(){
	var category_id=document.getElementById('kategorija').value;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_theme_change_select.php?category_id=" + category_id, true);
		httpObject.send(null);
		httpObject.onreadystatechange = admin_chg_select;
	}
}

/*--Add themes--*/

function add_the(){
	if(httpObject.readyState == 4){
		document.getElementById('query_input').innerHTML = httpObject.responseText;
		admin_theme_show();
		document.getElementById('naziv_teme').value="";
		document.getElementById('pitanje').value="";
	}
}

function add_theme(){
	var theme_name=document.getElementById('naziv_teme').value;
	var subcategory_id=document.getElementById('podkategorija').value;
	var question=document.getElementById('pitanje').value;
	reg_theme_name=/^[A-ZŽĆČĐŠ]{1,2}[a-zžćčđš0-9\-\s]{2,28}$/;
	reg_question=/^[A-ZŽĆČĐŠ]{1,2}[A-Za-zžćčđšŽĆČĐŠ\s\.\,\?\!\-0-9]{1,998}$/;

	if(subcategory_id=="0"){
		alert("Morate izabrati podkategoriju");
	}else if(!(reg_theme_name.test(theme_name))){
		alert("Greška naziv teme");
	}else if(!(reg_question.test(question))){
		alert("Greška pitanje");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("POST","./ajax/admin_theme_add.php",true);
			httpObject.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			httpObject.send("theme_name=" + theme_name + "&subcategory_id=" + subcategory_id + "&question=" + question);
			httpObject.onreadystatechange = add_the;
		}
	}

}

/*--Themes delete--*/

function delete_the(){
	if(httpObject.readyState == 4){
		admin_theme_show();
		document.getElementById('query_input').innerHTML = "";
	}
}

function delete_theme(a){
	var thema=a.id;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_theme_delete.php?thema=" + thema, true);
		httpObject.send(null);
		httpObject.onreadystatechange = delete_the;
	}
}

/*-Change theme-*/

function change_the(){
	if(httpObject.readyState == 4){
			document.getElementById('center_content').innerHTML = httpObject.responseText;
	}
}

function change_theme(){
	var theme_name=document.getElementById('naziv_teme').value;
	var theme_id=document.getElementById('id_teme').value;
	var subcategory_id=document.getElementById('podkategorija').value;
	var question=document.getElementById('pitanje').value;
	reg_theme_name=/^[A-ZŽĆČĐŠ]{1,2}[a-zžćčđš0-9\-\s]{2,28}$/;
	reg_question=/^[A-ZŽĆČĐŠ]{1,2}[A-Za-zžćčđšŽĆČĐŠ\s\.\,\?\!\-0-9]{1,998}$/;
	if(subcategory_id=="0"){
		alert('Morate izabrati podkategoriju');
	}else if(!(reg_theme_name.test(theme_name))){
		alert("Greška naziv kategorije");
	}else if(!(reg_question.test(question))){
		alert("Greška pitanje");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("POST","./ajax/admin_theme_change.php",true);
			httpObject.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			httpObject.send("theme_id=" + theme_id + "&theme_name=" + theme_name + "&subcategory_id=" + subcategory_id + "&question=" + question);
			httpObject.onreadystatechange = change_the;
		}
	}
}

/*Theme lock*/

function lock_the(){
	if(httpObject.readyState == 4){
		show_themes(document.getElementById('podkategorija').value);
	}
}

function lock_theme(a){
	var status="2";
	var theme_id=a.name;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_theme_lock.php?theme_id=" + theme_id + "&status=" + status, true);
		httpObject.send(null);
		httpObject.onreadystatechange = lock_the;
	}
}

/*Theme open*/

function open_the(){
	if(httpObject.readyState == 4){
		show_themes(document.getElementById('podkategorija').value);
	}
}

function open_theme(a){
	var status="1";
	var theme_id=a.name;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_theme_open.php?theme_id=" + theme_id + "&status=" + status, true);
		httpObject.send(null);
		httpObject.onreadystatechange = open_the;
	}
}

/*Admin posts*/

function admin_delete_po(){
	if(httpObject.readyState == 4){
		show_posts(document.getElementById('tema').value);
		document.getElementById('query_input').innerHTML = "";
	}
}

function admin_delete_post(a){
	var post=a.id;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_post_delete.php?post=" + post, true);
		httpObject.send(null);
		httpObject.onreadystatechange = admin_delete_po;
	}
}

function change_po(){
	if(httpObject.readyState == 4){
		document.getElementById('center_content').innerHTML = httpObject.responseText;
	}
}

function change_post(){
	var post=document.getElementById('odgovor').value;
	var post_id=document.getElementById('id_odgovora').value;
	reg_post=/^[A-ZŽĆČĐŠ]{1,2}[A-Za-zžćčđšŽĆČĐŠ\s\.\,\?\!\-0-9]{1,998}$/;

	if(!(reg_post.test(post))){
		alert("Greška sadržaj odgovora");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("POST","./ajax/admin_post_change.php",true);
			httpObject.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			httpObject.send("post=" + post + "&post_id=" + post_id);
			httpObject.onreadystatechange = change_po;
		}
	}

}

/*Admin user*/

function admin_use(){
	if(httpObject.readyState == 4){
		document.getElementById('admin_user_print').innerHTML = httpObject.responseText;
		online();
	}
}

function admin_user_show(a){
	if(a==0){
		document.getElementById('s').value=0;
	}
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}
	var username=document.getElementById('korisnicko_ime').value;
	reg_username=/^[A-Za-z]{0,30}$/;
	if(!(reg_username.test(username))){
		alert("Greška korisničko ime");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("GET", "./ajax/admin_user_show.php?username=" + username + "&s=" + s, true);
			httpObject.send(null);
			httpObject.onreadystatechange = admin_use;
		}
	}
}

function delete_use(){
	if(httpObject.readyState == 4){
		admin_user_show();
		document.getElementById('query_print').innerHTML = "";
	}
}

function delete_user(a){
	var user=a.id;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_user_delete.php?user=" + user, true);
		httpObject.send(null);
		httpObject.onreadystatechange = delete_use;
	}
}

/*Admin messages*/

function admin_mes(){
	if(httpObject.readyState == 4){
		document.getElementById('admin_message_print').innerHTML = httpObject.responseText;
		online();
	}
}

function admin_message_show(a){
	if(a==0){
		document.getElementById('s').value=0;
	}
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}
	var username=document.getElementById('korisnicko_ime').value;
	reg_username=/^[A-Za-z]{0,30}$/;
	if(!(reg_username.test(username))){
		alert("Greška korisničko ime");
	}else{
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("GET", "./ajax/admin_message_show.php?username=" + username + "&s=" + s, true);
			httpObject.send(null);
			httpObject.onreadystatechange = admin_mes;
		}
	}
}

function admin_mes_del(){
	if(httpObject.readyState == 4){
		admin_message_show();
	}
}

function admin_message_delete(a){
	var user=a.id;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/admin_message_delete.php?user=" + user, true);
		httpObject.send(null);
		httpObject.onreadystatechange = admin_mes_del;
	}
}

/*Messages*/

function show_new_mes(){
	if(httpObject.readyState == 4){
		document.getElementById('center_content').innerHTML = httpObject.responseText;
		online();
	}
}

function show_new_messages(a){
	var user=a;
	httpObject = getHTTPObject();
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/show_new_messages.php?user=" + user + "&s=" + s, true);
		httpObject.send(null);
		httpObject.onreadystatechange = show_new_mes;
	}
}

function show_read_mes(){
	if(httpObject.readyState == 4){
		document.getElementById('center_content').innerHTML = httpObject.responseText;
		online();
	}
}

function show_read_messages(a){
	var user=a;
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/show_read_messages.php?user=" + user + "&s=" + s, true);
		httpObject.send(null);
		httpObject.onreadystatechange = show_read_mes;
	}
}

function show_sent_mes(){
	if(httpObject.readyState == 4){
		document.getElementById('center_content').innerHTML = httpObject.responseText;
		online();
	}
}

function show_sent_messages(a){
	var user=a;
	if(document.getElementById('s')){
		var s=document.getElementById('s').value;
	}else{
		var s=0;
	}
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/show_sent_messages.php?user=" + user + "&s=" + s, true);
		httpObject.send(null);
		httpObject.onreadystatechange = show_sent_mes;
	}
}

/*Delete messages*/

function delete_mes(){
	if(httpObject.readyState == 4){
		var izvrsi=document.getElementById('izvrsi').value;
		if(izvrsi=="show_read_messages"){
			show_read_messages(document.getElementById('korisnik').value);
		}else if(izvrsi=="show_sent_messages"){
			show_sent_messages(document.getElementById('korisnik').value);
		}else if(izvrsi=="show_new_messages"){
			show_new_messages(document.getElementById('korisnik').value);
		}
	}
}

function delete_message(a){
	var message=a.id;
	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/message_delete.php?message=" + message, true);
		httpObject.send(null);
		httpObject.onreadystatechange = delete_mes;
	}
}

/*Search*/

function src(){
	if(httpObject.readyState == 4){
		document.getElementById('center_content').innerHTML = httpObject.responseText;
	}
}

function search(){
	var select=document.getElementById('izaberi').value;
	var name=document.getElementById('naziv').value;
	if(select=="0"){
		alert("Morate izabrati po čemu pretražujete");
		return false;
	}else if(select=="1"){
		reg_name=/^[A-ZŽĆČĐŠa-zžćčđš0-9\-\s]{0,30}$/;
		if(!reg_name.test(name)){
			alert("Greška naziv");
			return false;
		}
	}else if(select=="2"){
		reg_name=/^[A-Za-z]{0,30}$/;
		if(!reg_name.test(name)){
			alert("Greška naziv");
			return false;
		}
	}

	httpObject = getHTTPObject();
	if (httpObject != null) {
		httpObject.open("GET", "./ajax/search.php?select=" + select + "&name=" + name, true);
		httpObject.send(null);
		httpObject.onreadystatechange = src;
	}
}

/*-Registration-*/
function show_mo(){
	if(httpObject.readyState == 4){
		document.getElementById('mesec').innerHTML = httpObject.responseText;
	}
}

function show_month(){
	var year=document.getElementById('godina').value;
	if(year=="0"){
		document.getElementById('dan').style.display="none";
		document.getElementById('mesec').style.display="none";
	}else{
		document.getElementById('mesec').style.display="block";
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("GET","./ajax/show_month.php?year=" + year,true);
			httpObject.send(null);
			httpObject.onreadystatechange = show_mo;
		}
	}
}

function show_d(){
	if(httpObject.readyState == 4){
		document.getElementById('dan').innerHTML = httpObject.responseText;
	}
}

function show_day(){
	var year=document.getElementById('godina').value;
	var month=document.getElementById('mesec').value;
	if(month=="0"){
		document.getElementById('dan').style.display="none";
	}else{
		document.getElementById('dan').style.display="block";
		httpObject = getHTTPObject();
		if (httpObject != null) {
			httpObject.open("GET","./ajax/show_day.php?year=" + year + "&month=" + month,true);
			httpObject.send(null);
			httpObject.onreadystatechange = show_d;
		}
	}
}


var httpObject = null;
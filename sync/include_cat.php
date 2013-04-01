<?php
include_once '../colab/db.php';
mysql_connect($db_host,$db_username,$db_password);
mysql_select_db($db_name) or die(mysql_error());

$projetos = $_POST[projetos];

foreach ($projetos as $projeto) {
	$id = $projeto[id];
	$pin = $projeto[pin];
	$has_pin = false;
	
	$result = mysql_query("SELECT meta_id FROM `wp_postmeta` WHERE post_id LIKE '$id' AND meta_key LIKE '_mpv_pin'");
	$row = mysql_num_rows($result);
	
	if ($row > 0) $has_pin = true;
	
	if(empty($pin)) continue;
	if($has_pin == true) {
		/* Não atualizando por enquanto
		mysql_query("UPDATE wp_postmeta
					SET meta_value='a:2:{s:3:\"lat\";d:$lat;s:3:\"lon\";d:$long;}'
					WHERE post_id=$id AND meta_key='_mpv_location'") or die(mysql_error());
		echo "<p><small>Pin do projeto $projeto[nome] atualizado com sucesso.</p></small>";
		*/
	} else {
		mysql_query("INSERT INTO wp_postmeta
				VALUES (NULL, $id, '_mpv_pin', '$pin')") or die(mysql_error());
		echo "<p><small>Pin do projeto $projeto[nome] inserido com sucesso.</p></small>";
	}
}

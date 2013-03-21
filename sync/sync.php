<?php
include_once '../colab/db.php';
mysql_connect($db_host,$db_username,$db_password);
mysql_select_db($db_name) or die(mysql_error());

$projetos = $_POST[projetos];

foreach ($projetos as $projeto) {
	$id = $projeto[id];
	$lat = $projeto[lat];
	$long = $projeto[long];
	if($projeto[pin] == true) {
		mysql_query("UPDATE wp_postmeta
					SET meta_value='a:2:{s:3:\"lat\";d:$lat;s:3:\"lon\";d:$long;}'
					WHERE post_id=$id AND meta_key='mpv_location'") or die(mysql_error());
		echo "<p><small>Pin do projeto $projeto[nome] atualizado com sucesso.</p></small>";
	} else {
		mysql_query("INSERT INTO wp_postmeta
					VALUES (NULL, $id, '_mpv_inmap', '1439')") or die(mysql_error());
		mysql_query("INSERT INTO wp_postmeta
				VALUES (NULL, $id, '_mpv_location', 'a:2:{s:3:\"lat\";d:$lat;s:3:\"lon\";d:$long;}')") or die(mysql_error());
		echo "<p><small>Pin do projeto $projeto[nome] inserido com sucesso.</p></small>";
	}
}
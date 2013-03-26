<?php
include_once '../colab/db.php';
mysql_connect($db_host,$db_username,$db_password);
mysql_select_db($db_name) or die(mysql_error());

$projetos = $_POST[projetos];

$id = $_GET[id];
$lat = $_GET[lat];
$lng = $_GET[lng];
$pin = false;

$result = mysql_query("SELECT meta_id FROM `wp_postmeta` WHERE post_id LIKE '$id' AND meta_key LIKE '_mpv_location'");
$row = mysql_num_rows($result);

if ($row > 0) $pin = true;

if($pin == true) {
	mysql_query("UPDATE wp_postmeta
				SET meta_value='a:2:{s:3:\"lat\";d:$lat;s:3:\"lon\";d:$lng;}'
				WHERE post_id=$id AND meta_key='_mpv_location'") or die(mysql_error());
	echo "<p><small>Pin do projeto $id atualizado com sucesso.</p></small>";
} else {
	mysql_query("INSERT INTO wp_postmeta
				VALUES (NULL, $id, '_mpv_inmap', '1439')") or die(mysql_error());
	mysql_query("INSERT INTO wp_postmeta
			VALUES (NULL, $id, '_mpv_location', 'a:2:{s:3:\"lat\";d:$lat;s:3:\"lon\";d:$l	ng;}')") or die(mysql_error());
	echo "<p><small>Pin do projeto $id inserido com sucesso.</p></small>";
}


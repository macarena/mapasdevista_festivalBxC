<?php
include_once '../colab/db.php';
mysql_connect($db_host,$db_username,$db_password);
mysql_select_db($db_name) or die(mysql_error());

$projetos = $_POST[projetos];

$id = $_GET[id];
$lat = $_GET[lat];
$lng = $_GET[lng];
$add_cat = $_GET[add_cat];
$del_cat = $_GET[del_cat];
$add_data = $_GET[add_data];
$del_data = $_GET[del_data];
$content = $_GET[content];
$pin = false;

if (!empty($lat) and !empty($lng)) {
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
}

if (!empty($content)) {
		$content = mysql_real_escape_string($content);
		mysql_query("UPDATE wp_posts
					SET post_content='{$content}'
					WHERE ID=$id") or die(mysql_error());
		echo "<p><small>Conteúdo do projeto $id atualizado com sucesso.</p></small>";
} elseif($_GET[input_content]) {
	?>
<form enctype="multipart/form-data">
 <input type='text' name='id' /><br>
 <textarea rows="10" cols="80" name='content'></textarea>
 <button type="submit" formaction="sync_get.php" formmethod="get">Syncar!</button> 
</form>	 <?php
}

if (!empty($add_cat)) {
	mysql_query("INSERT INTO `wp_term_relationships`
				VALUES ($id, $add_cat, 0)") or die(mysql_error());
	echo "<p><small>Projeto $id adicionado a categoria $add_cat com sucesso.</p></small>";
}

if (!empty($del_cat)) {
	mysql_query("DELETE FROM `wp_term_relationships`
				WHERE `object_id` = $id AND `term_taxonomy_id` = $del_cat") or die(mysql_error());
	echo "<p><small>Projeto $id removido a categoria $del_cat com sucesso.</p></small>";
}

if (!empty($add_data)) {
	mysql_query("INSERT INTO `wp_term_relationships`
	VALUES ($id, $add_data, 0)") or die(mysql_error());
	echo "<p><small>Projeto $id adicionado a categoria $add_data com sucesso.</p></small>";
}

if (!empty($del_data)) {
	mysql_query("DELETE FROM `wp_term_relationships`
	WHERE `object_id` = $id AND `term_taxonomy_id` = $del_data") or die(mysql_error());
	echo "<p><small>Projeto $id removido a categoria $del_data com sucesso.</p></small>";
}
?>
<?php
include_once '../colab/db.php';
mysql_connect($db_host,$db_username,$db_password);
mysql_select_db($db_name) or die(mysql_error());

$projetos = $_POST[projetos];

$id = $_GET[id];
$lat = $_GET[lat];
$lng = $_GET[lng];
$cat = $_GET[cat];
$data = $_GET[data];
$add_cat = $_GET[add_cat];
$del_cat = $_GET[del_cat];
$add_data = $_GET[add_data];
$del_data = $_GET[del_data];
$content = $_GET[content];
$title = $_GET[title];
$excerpt = $_GET[excerpt];
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
}
if (!empty($title)) {
	$title= mysql_real_escape_string($title);
	mysql_query("UPDATE wp_posts
	SET post_title='{$title}'
	WHERE ID=$id") or die(mysql_error());
	echo "<p><small>Título do projeto $id atualizado com sucesso.</p></small>";
}
if (!empty($excerpt)) {
	$excerpt = mysql_real_escape_string($excerpt);
	mysql_query("UPDATE wp_posts
	SET post_excerpt='{$excerpt}'
	WHERE ID=$id") or die(mysql_error());
	echo "<p><small>Resumo do projeto $id atualizado com sucesso.</p></small>";
}

if($_GET[input] AND empty($content) AND empty($title) AND empty($excerpt)) {
	?>
	<form enctype="multipart/form-data">
		ID:<input type='text' name='id' /><br>
		TITLE:<input type='text' name='title' /><br>
		EXCERPT:<textarea rows="10" cols="80" name='excerpt'></textarea><br>
		CONTENT:<textarea rows="10" cols="80" name='content'></textarea>
		<button type="submit" formaction="sync_get.php" formmethod="get">Syncar!</button> 
	</form>
	<?php
}

/*
1 Música
2 Artes integradas
4 Audiovisual
5 Teatro
6 Performance
7 Letras
8 Encontros & Passeios
9 Dança
10 Conversas, debates, laboratórios
11 Cultura digital
12 Oficinas
 * 
 * 
 *
1236 07/04
1241 13/04
1243 sem-data
1244 06/04
1245 05/04
1249 08/04
1250 09/04
1251 10/04
1252 11/04
1253 12/04
1254 14/04
*/

if (!empty($cat)) {
	mysql_query("DELETE FROM `wp_term_relationships`
	WHERE `object_id` = $id
	AND	(`term_taxonomy_id` = 1
	OR	`term_taxonomy_id` = 2
	OR	`term_taxonomy_id` = 4
	OR	`term_taxonomy_id` = 5
	OR	`term_taxonomy_id` = 6
	OR	`term_taxonomy_id` = 7
	OR	`term_taxonomy_id` = 8
	OR	`term_taxonomy_id` = 9
	OR	`term_taxonomy_id` = 10
	OR	`term_taxonomy_id` = 11
	OR	`term_taxonomy_id` = 12)") or die(mysql_error());
	mysql_query("INSERT INTO `wp_term_relationships`
	VALUES ($id, $cat, 0)") or die(mysql_error());
	echo "<p><small>Projeto $id adicionado a categoria $cat com sucesso.</p></small>";
}

if (!empty($data)) {
	mysql_query("DELETE FROM `wp_term_relationships`
	WHERE `object_id` = $id
	AND	(`term_taxonomy_id` = 1236
	OR	`term_taxonomy_id` = 1241
	OR	`term_taxonomy_id` = 1243
	OR	`term_taxonomy_id` = 1244
	OR	`term_taxonomy_id` = 1245
	OR	`term_taxonomy_id` = 1249
	OR	`term_taxonomy_id` = 1250
	OR	`term_taxonomy_id` = 1251
	OR	`term_taxonomy_id` = 1252
	OR	`term_taxonomy_id` = 1253
	OR	`term_taxonomy_id` = 1254)") or die(mysql_error());						
	mysql_query("INSERT INTO `wp_term_relationships`
	VALUES ($id, $data, 0)") or die(mysql_error());
	echo "<p><small>Projeto $id adicionado a categoria $data com sucesso.</p></small>";
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
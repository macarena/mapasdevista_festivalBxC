<?php
$format = get_post_format() ? get_post_format() : 'default';
?>

<?php
	$term_datas = wp_get_post_terms($post->ID,'category');
	$data_name = array();
//código antigo
//	foreach($term_datas as $term_data) $data_name[] = $term_data->name;
//	$data_name = implode(', ', $data_name);
//tentando pegar a categoria principal pegando a categoria sem parent 
	foreach($term_datas as $term_data) {
		if($term_data->parent == 0) $categoria = $term_data->name;
	}
?>

<?php
$id = $post->ID;
$json = file_get_contents("http://199.127.227.146/bxc2013/colab!projetoMapa.action?codProjetoMysql=$id");
$values = json_decode($json, true);
$values = $values[values];

//print_r('<pre>');
//var_dump(json_decode($json));
//var_dump(json_decode($json, true));
//print_r($values);
//print_r('</pre>');

?>

<? $tid = wp_get_attachment_image_src( get_post_thumbnail_id(), array(420,190)); ?>
<div id="post_<?php the_ID(); ?>_thumb" class="thumb <?php echo $format; ?> clearfix" style="background: url(<? echo $tid[0] ?>) no-repeat center" ></div>
<div id="post_<?php the_ID(); ?>" class="entry <?php echo $format; ?> clearfix">
<? $dados = get_post_custom(); //print_r($dados);?>
	<p class="categoria"><? echo $categoria ?></p>
	<h1 class="titulo"><?php the_title(); ?></h1>
	<p class="metadata data hora"><span class="data"><?php echo substr($values[data],0,5); ?></span> <span class="hora"><?php echo $values[hora]; ?></span></p>
	<p class="localizacao"><?php echo $values[nomLocal];?> <a href="http://maps.google.com/maps?q=<?php echo str_replace(array('a:2:{s:3:"lat";d:',';s:3:"lon";d:',';}'), array('',',',''), $dados[_mpv_location][0]);?>" target='_blank' style='text-decoration: none;'><small>como chegar</small></a></p>

	<?php mapasdevista_get_template( 'mapasdevista-content' ); ?>
</div>

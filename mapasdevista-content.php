<? $dados = get_post_custom(); ?>
<?php
$id = $post->ID;
$json = file_get_contents("http://199.127.227.146/bxc2013/colab!projetoMapa.action?codProjetoMysql=$id");
$values = json_decode($json, true);
$values = $values[values];

?>
<section id="entry-content" class="clearfix">
	<?php the_content(); ?>
</section>

<h2 class="autor">Autores</h2>
<p class="metadata autor">
	<?php echo $values[nomResponsavel]; ?>
</p>

<h2 class="equipe">Equipe</h2>

<?php
$i = "primeiro";
foreach($dados[demanda] as $k=>$v) {
	$voluntario = ($dados[voluntario][$k])
	?"<p class=\"oferta ok\"><span class=\"voluntario\">preenchida!</span></p>"
	: "<p class=\"oferta\"><span class=\"voluntario\">quero ser!</span></p>";
	?>
<p class="metadata equipe <? echo $i ?>">
	<span class="demanda"><?php echo $v; ?> </span>
</p><?php echo $voluntario ?>
<?php
$i = '';
}
?>

<h2 class="equipamentos">Equipamentos</h2>
<?php

$i = "primeiro";
foreach($values[equipos] as $v) {
?>
<p class="metadata equipe <? echo $i ?>">
	<span class="demanda"><?php echo $v[nome]; ?> </span>
</p><p class="oferta"><span class="voluntario"><a href="wp-content/themes/mapasdevista_festivalBxC/colab/form.php?proj_id=<?php echo $post->ID; ?>&codEquipo=<?php echo $v[codEquipo]; ?>">emprestar!</a></span></p>
<?php
$i = '';
}
?>

<?php
//plugin para envio de e-mail a cada atualização - Mailing List Subscribers
$args = array(
		'prepend' => '',
		'showname' => true,
		'nametxt' => 'Name:',
		'nameholder' => 'Name...',
		'emailtxt' => 'Email:',
		'emailholder' => 'Email Address...',
		'showsubmit' => true,
		'submittxt' => 'Submit',
		'jsthanks' => false,
		'thankyou' => 'Thank you for subscribing to our mailing list'
);

//isso aqui é o print do plugin onde o usuário se subscreve para receber atualizações, e precisa virar um botão - "quero acompanhar"
//Desativado aguardando CSS
//echo smlsubform($args);

?>

<?php comments_template(); ?>

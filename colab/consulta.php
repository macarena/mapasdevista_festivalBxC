<?php
/*
 * configuração do BD
 * ---------------------------------------------------------------------
 *  */
include_once 'db.php';
/*
 * HEAD do HTML
 * ---------------------------------------------------------------------
 *  */
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="consulta.css">
</head>
<body>
<?php 
/*
 * FORM
 * ---------------------------------------------------------------------
 *  */
?>

	<div class="form">
	<form method="post" name="consulta" id="consulta" action="consulta.php">
	
		<dl>
			<dt>
				<label for="Base">Base</label>
			</dt>
			<dd>
				<select size="1" name="base" id="base">
					<option value="Trampos">Trampos</option>
					<option value="Equipos">Equipos</option>
					<option value="Locais">Locais</option>
				</select>
			</dd>
		</dl>
	
		<div id="submit_buttons">
			<button type="submit">Consultar</button>
		</div>

	</form>
	</div>

<?php
/*
 * Acesso BD
 * ---------------------------------------------------------------------
 *  */
	$connection=mysql_connect($db_host,$db_username,$db_password); if (mysql_errno($connection))  { die("erro: ".__LINE__." | Sem acesso ao MySQL - " . mysql_errno() . ": " . mysql_error() . " .");	}
	$db = mysql_select_db($db_name,$connection); if (!$db) { die("erro: ".__LINE__." | Sem acesso à base de dados - " . mysql_errno() . ": " . mysql_error() . " ."); };
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
?>
<?php	
/*
 * Consulta Trampos
 * ---------------------------------------------------------------------
 *  */
if ($_POST["base"]=="Trampos")
{
?>
	
	<div class="form">
	<form method="post" name="consulta" id="consulta" action="consulta.php">
	
		<input type="hidden" name="base" value="Trampos" />
	
		<dl>
			<dt>
				<label for="Projeto"> Projeto [id] </label>
			</dt>
			<dd><input type="text" id="projeto" name="projeto" value="<?php if($_POST['projeto']) { echo "".strip_tags($_POST['projeto']).""; } ?>" /></dd>
		</dl>
	
		<div id="submit_buttons">
			<button type="submit">Consultar</button>
		</div>

	</form>
	</div>

<div class="top">
	TRAMPOS
</div>

	<?php	
	if($_POST['projeto'])
	{
		$ff = "registros para o projeto ".strip_tags($_POST['projeto'])."";
	} 
	else
	{
		$ff = "últimos 30 registros inseridos";
	}
	?>

<table id="trampos" class="consulta" summary="Baixo Centro">
<thead>
<tr>
<th scope="col">Nome</th>
<th scope="col">Email</th>
<th scope="col">Telefone</th>
<th scope="col">Trampos</th>
<th scope="col">Outros</th>
<th scope="col">Habilidades</th>
</tr>
</thead>
<tfoot>
<tr>
<td colspan="6"><em>Busca: <?php echo $ff ?></em></td>
</tr>
</tfoot>
<tbody>

	<?php	
	if($_POST['projeto'])
	{
		$where = "WHERE proj='".strip_tags($_POST['projeto'])."' ";
	} 
	$query = "
		SELECT oferta_voluntarios.nome, oferta_voluntarios.email, oferta_voluntarios.telefone, oferta_trampos.tipos, oferta_trampos.outros, oferta_trampos.habilidades
		FROM oferta_voluntarios
		INNER JOIN oferta_trampos 
		ON ( oferta_voluntarios.email = oferta_trampos.voluntario )".
		$where
		."ORDER BY id DESC
		LIMIT 30	
	"; 
	$result = mysql_query($query); 
	if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };
	while($row = mysql_fetch_array($result))
	{
		echo "<tr>"."\n";
		echo "<td>".$row['nome']."</td>"."\n";
		echo "<td>".$row['email']."</td>"."\n";
		echo "<td>".$row['telefone']."</td>"."\n";
		echo "<td>".$row['tipos']."</td>"."\n";
		echo "<td>".$row['outros']."</td>"."\n";
		echo "<td>".$row['habilidades']."</td>"."\n";
		echo "</tr>"."\n";
	}
	?>

</tbody>
</table>


<?php	
}
elseif ($_POST["base"]=="Equipos")
{
/*
 * Consulta Equipos
 * ---------------------------------------------------------------------
 *  */
?>

	<div class="form">
	<form method="post" name="consulta" id="consulta" action="consulta.php">
	
		<input type="hidden" name="base" value="Equipos" />
	
		<dl>
			<dt>
				<label for="Projeto"> Projeto [id] </label>
			</dt>
			<dd><input type="text" id="projeto" name="projeto" value="<?php if($_POST['projeto']) { echo "".strip_tags($_POST['projeto']).""; } ?>" /></dd>
		</dl>
	
		<div id="submit_buttons">
			<button type="submit">Consultar</button>
		</div>

	</form>
	</div>

<div class="top">
	EQUIPOS
</div>

	<?php	
	if($_POST['projeto'])
	{
		$ff = "registros para o projeto ".strip_tags($_POST['projeto'])."";
	} 
	else
	{
		$ff = "últimos 30 registros inseridos";
	}
	?>


<table id="equipos" class="consulta" summary="Baixo Centro">
<thead>
<tr>
<th scope="col">Nome</th>
<th scope="col">Email</th>
<th scope="col">Telefone</th>
<th scope="col">Tipos</th>
<th scope="col">Outros</th>
<th scope="col">Descrição</th>
<th scope="col">Entregar</th>
<th scope="col">Retirada</th>
<th scope="col">Endereço</th>
</tr>
</thead>
<tfoot>
<tr>
<td colspan="9"><em>Busca: <?php echo $ff ?></em></td>
</tr>
</tfoot>
<tbody>

<?php	
	if($_POST['projeto'])
	{
		$where = "WHERE proj='".strip_tags($_POST['projeto'])."' ";
	} 
	$query = "
		SELECT oferta_voluntarios.nome, oferta_voluntarios.email, oferta_voluntarios.telefone, oferta_equipos.tipos, oferta_equipos.outros,
		oferta_equipos.descricao, oferta_equipos.entregar,  oferta_equipos.data_retirada,  oferta_equipos.end_retirada
		FROM oferta_voluntarios
		INNER JOIN oferta_equipos 
		ON ( oferta_voluntarios.email = oferta_equipos.voluntario )".
		$where
		."
		ORDER BY id DESC
		LIMIT 30	
	"; 
	$result = mysql_query($query); 
	if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };
	while($row = mysql_fetch_array($result))
	{
		echo "<tr>"."\n";
		echo "<td>".$row['nome']."</td>"."\n";
		echo "<td>".$row['email']."</td>"."\n";
		echo "<td>".$row['telefone']."</td>"."\n";
		echo "<td>".$row['tipos']."</td>"."\n";
		echo "<td>".$row['outros']."</td>"."\n";
		echo "<td>".$row['descricao']."</td>"."\n";
		if ($row['entregar'])
		{
			echo "<td>Sim</td>"."\n";
		}
		else
		{
			echo "<td>Não</td>"."\n";		
		}	
		echo "<td>".$row['data_retirada']."</td>"."\n";
		echo "<td>".$row['end_retirada']."</td>"."\n";
		echo "</tr>"."\n";
	}
?>

</tbody>
</table>


<?php	
}
elseif ($_POST["base"]=="Locais")
{
/*
 * Consulta Locais
 * ---------------------------------------------------------------------
 *  */
?>

	<div class="form">
	<form method="post" name="consulta" id="consulta" action="consulta.php">
	
		<input type="hidden" name="base" value="Locais" />
	
		<dl>
			<dt>
				<label for="Projeto"> Projeto [id] </label>
			</dt>
			<dd><input type="text" id="projeto" name="projeto" value="<?php if($_POST['projeto']) { echo "".strip_tags($_POST['projeto']).""; } ?>" /></dd>
		</dl>
	
		<div id="submit_buttons">
			<button type="submit">Consultar</button>
		</div>

	</form>
	</div>

<div class="top">
	LOCAIS
</div>

	<?php	
	if($_POST['projeto'])
	{
		$ff = "registros para o projeto ".strip_tags($_POST['projeto'])."";
	} 
	else
	{
		$ff = "últimos 30 registros inseridos";
	}
	?>

<table id="locais" class="consulta" summary="Baixo Centro">
<thead>
<tr>
<th scope="col">Nome</th>
<th scope="col">Email</th>
<th scope="col">Telefone</th>
<th scope="col">Tipos</th>
<th scope="col">Outros</th>
<th scope="col">Nome</th>
<th scope="col">Endereço</th>
<th scope="col">Capacidade</th>
<th scope="col">Datas</th>
<th scope="col">Descrição</th>
<th scope="col">Estac</th>
<th scope="col">Infra Deficientes</th>
</tr>
</thead>
<tfoot>
<tr>
<td colspan="12"><em>Busca: <?php echo $ff ?></em></td>
</tr>
</tfoot>
<tbody>

<?php	
	if($_POST['projeto'])
	{
		$where = "WHERE proj='".strip_tags($_POST['projeto'])."' ";
	} 
	$query = "
		SELECT oferta_voluntarios.nome, oferta_voluntarios.email, oferta_voluntarios.telefone, oferta_locais.tipos, oferta_locais.outros,
		oferta_locais.nome, oferta_locais.endereco, oferta_locais.capacidade, oferta_locais.datas, oferta_locais.descricao, 
		oferta_locais.estacionamento, oferta_locais.atende_def
		FROM oferta_voluntarios
		INNER JOIN oferta_locais 
		ON ( oferta_voluntarios.email = oferta_locais.voluntario )".
		$where
		."ORDER BY id DESC
		LIMIT 30	
	"; 
	$result = mysql_query($query); 
	if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };
	while($row = mysql_fetch_array($result))
	{
		echo "<tr>"."\n";
		echo "<td>".$row['nome']."</td>"."\n";
		echo "<td>".$row['email']."</td>"."\n";
		echo "<td>".$row['telefone']."</td>"."\n";
		echo "<td>".$row['tipos']."</td>"."\n";
		echo "<td>".$row['outros']."</td>"."\n";
		echo "<td>".$row['nome']."</td>"."\n";
		echo "<td>".$row['endereco']."</td>"."\n";
		echo "<td>".$row['capacidade']."</td>"."\n";
		echo "<td>".$row['datas']."</td>"."\n";
		echo "<td>".$row['descricao']."</td>"."\n";
		if ($row['estacionamento'])
		{
			echo "<td>Sim</td>"."\n";
		}
		else
		{
			echo "<td>Não</td>"."\n";
		}
		echo "<td>".$row['atende_def']."</td>"."\n";
		echo "</tr>"."\n";
	}
}
?>

</tbody>
</table>

</body>
</html>

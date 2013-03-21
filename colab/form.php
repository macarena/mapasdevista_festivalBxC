<?php
/*
 * configuração do BD
 * ---------------------------------------------------------------------
 *  */

	$db_host = "host.baixocentro.org";
	$db_username = "baixocentro";
	$db_password = "ruasparadancar";
	$db_name = "baixocentro2013_mapa";

?>

<?php
/*
 * recebe variáreis do formulário
 * ---------------------------------------------------------------------
 *  */

	$voluntario_email = strip_tags($_POST["email"]);
	if ($_POST["proj"]) { $projeto = strip_tags($_POST["proj"]);  } else { $projeto = "1"; };

/*
 * charset
 * ---------------------------------------------------------------------
 *  /
	header('Content-Type: text/html; charset=utf-8');

/*
 * HEAD do HTML
 * ---------------------------------------------------------------------
 *  */
?>

<html>
<head>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="form.css">

</head>
<body>

<?php
/*
 * form ABRE
 * ---------------------------------------------------------------------
 *  */
if (!$_POST["form"]) 
{
?>

	<div class="form">
	<form method="post" name="form_abre" id="form_abre" action="form.php">

		<div class="abertura">

			Para colaborar com este projeto, identifique-se abaixo...

		</div>

		<input type="hidden" name="form" value="form_identifica" />

		<dl>
			<dt>

				<label for="projeto">Projeto [id] </label>

			</dt>
			<dd>

				<input type="text" id="projeto" name="proj" />

			</dd>
		</dl>
		
		<dl>
			<dt>

				<label for="email">Email*</label>

			</dt>
			<dd>

				<input type="text" id="email" class="required" name="email" />

			</dd>
		</dl>
		
		<div id="submit_buttons">

			<button type="submit">Quero participar!</button>

		</div>

	</form>
	</div>

<?php
/*
 * verifica formulário atual
 * ---------------------------------------------------------------------
 *  */

} 
elseif ($_POST["form"]=="form_identifica") 
{

/*
 * BD: cria ou recupera Voluntário
 * ---------------------------------------------------------------------
 *  */
	$connection=mysql_connect($db_host,$db_username,$db_password); if (mysql_errno($connection))  { die("erro: ".__LINE__." | Sem acesso ao MySQL - " . mysql_errno() . ": " . mysql_error() . " .");	}
	$db = mysql_select_db($db_name,$connection); if (!$db) { die("erro: ".__LINE__." | Sem acesso à base de dados - " . mysql_errno() . ": " . mysql_error() . " ."); };
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');

	if ($voluntario_email)
	{	
		$query = "SELECT * FROM oferta_voluntarios WHERE email='".$voluntario_email."' LIMIT 1"; 
		$result = mysql_query($query); 
		if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };
		$row = mysql_fetch_row($result);
		if ($row) 
		{
			$voluntario_nome = $row[1];
			$voluntario_telefone = $row[2];
		} 
		else 
		{ 
			$query = "INSERT INTO oferta_voluntarios "."(email) "."VALUES "."('".$voluntario_email."')";	
			$result = mysql_query($query); if (!$result) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };	
		};
	} 
	else
	{
	   $show="form_identifica";
	};

/*
 * BD: recupera Projeto
 * ---------------------------------------------------------------------
 *  */

	if ($projeto)
	{	
		$query = "SELECT * FROM wp_posts WHERE ID='".$projeto."' LIMIT 1"; 
		$result = mysql_query($query); 
		if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };
		$row = mysql_fetch_row($result);
		if ($row) 
		{
			$post_title = $row[5];
			$post_url = $row[18];
		};
	} 
	else
	{
	   $show="form_identifica";
	};

/*
 * verifica se há dados de formulário de oferta
 * ---------------------------------------------------------------------
 *  */
	if($_POST["trampos"]) 
	{

		/* BD: cria Trampo */
		if(isset($_POST["trampos"])) 
		{
			for( $i = 0; $i < count($_POST["trampos"]); $i++ ) 
			{
            $tipos .= "".strip_tags($_POST["trampos"][$i]).", ";
         }
      }
		$outros = strip_tags($_POST["outros"]);
		$habilidades = strip_tags($_POST["habilidades"]);		
		$connection=mysql_connect($db_host,$db_username,$db_password); if (mysql_errno($connection))  { die("erro: ".__LINE__." | Sem acesso ao MySQL - " . mysql_errno() . ": " . mysql_error() . " .");	}
		$db = mysql_select_db($db_name,$connection); if (!$db) { die("erro: ".__LINE__." | Sem acesso à base de dados - " . mysql_errno() . ": " . mysql_error() . " ."); };
		$query = "INSERT INTO oferta_trampos "."(`voluntario`,`proj`,`id`,`tipos`,`outros`,`habilidades`)"." VALUES "."('".$voluntario_email."','".$projeto."','','".$tipos."','".$outros."','".$habilidades."')";	
		$result = mysql_query($query); if (!$result) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };	
		/**/
		$msg = "A sua oferta de mão de obra foi registrada!";

	} 
	elseif ($_POST["equipos"]) 
	{

		/* BD: cria Equipo */
		if(isset($_POST["equipos"])) 
		{
			for( $i = 0; $i < count($_POST["equipos"]); $i++ ) 
			{
            $tipos .= "".strip_tags($_POST["equipos"][$i]).", ";
         }
      }
		$outros = strip_tags($_POST["outros"]);
		$descricao = strip_tags($_POST["descricao"]);
		$entregar = strip_tags($_POST["entregar"]);
		$data_retirada = strip_tags($_POST["data_retirada"]);
		$end_retirada = strip_tags($_POST["end_retirada"]);
		$connection=mysql_connect($db_host,$db_username,$db_password); if (mysql_errno($connection))  { die("erro: ".__LINE__." | Sem acesso ao MySQL - " . mysql_errno() . ": " . mysql_error() . " .");	}
		$db = mysql_select_db($db_name,$connection); if (!$db) { die("erro: ".__LINE__." | Sem acesso à base de dados - " . mysql_errno() . ": " . mysql_error() . " ."); };
		$query = "INSERT INTO oferta_equipos "."(`voluntario`,`proj`,`id`,`tipos`,`outros`,`descricao`,`entregar`,`data_retirada`,`end_retirada`)"." VALUES "."('".$voluntario_email."','".$projeto."','','".$tipos."','".$outros."','".$descricao."','".$entregar."','".$data_retirada."','".$end_retirada."')";	
		$result = mysql_query($query); if (!$result) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };	
		/**/
		$msg = "A sua oferta de equipamento foi registrada!";

	} 
	elseif ($_POST["locais"]) 
	{

		/* BD: cria Local */		
		if(isset($_POST["locais"])) 
		{
			for( $i = 0; $i < count($_POST["locais"]); $i++ ) 
			{
            $tipos .= "".$_POST["locais"][$i].", ";
         }
      }		
		$outros = strip_tags($_POST["outros"]);
		$nome = strip_tags($_POST["nome"]);		
		$endereco = strip_tags($_POST["endereco"]);		
		$capacidade = strip_tags($_POST["capacidade"]);		
		$datas = strip_tags($_POST["datas"]);		
		$descricao = strip_tags($_POST["descricao"]);
		$entrega = strip_tags($_POST["entrega"]);		
		$estacionamento = strip_tags($_POST["estacionamento"]);		
		$atende_def = strip_tags($_POST["atende_def"]);		
		$connection=mysql_connect($db_host,$db_username,$db_password); if (mysql_errno($connection))  { die("erro: ".__LINE__." | Sem acesso ao MySQL - " . mysql_errno() . ": " . mysql_error() . " .");	}
		$db = mysql_select_db($db_name,$connection); if (!$db) { die("erro: ".__LINE__." | Sem acesso à base de dados - " . mysql_errno() . ": " . mysql_error() . " ."); };
		$query = "INSERT INTO oferta_locais "."(`voluntario`,`proj`,`id`,`tipos`,`outros`,`nome`,`endereco`,`capacidade`,`datas`,`descricao`,`estacionamento`,`atende_def`)"." VALUES "."('".$voluntario_email."','".$projeto."','','".$tipos."','".$outros."','".$nome."','".$endereco."','".$capacidade."','".$datas."','".$descricao."','".$estacionamento."','".$atende_def."')";	
		$result = mysql_query($query); if (!$result) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };	
		/**/
		$msg = "A sua oferta de local foi registrada!";		

	};

/*
 * apresenta formulário de voluntário
 * ---------------------------------------------------------------------
 *  */

	if($voluntario_email) 
	{

/*
 * form IDENTIFICA
 * ---------------------------------------------------------------------
 *  */
?>

	<div class="form">
	<form method="post" name="form_identifica" id="form_identifica" action="form.php">

		<div class="projeto">

			<b>PROJETO:</b><a href="<?php echo $post_title; ?>"> <?php echo $post_title; ?> </a>

		</div>

		<div class="abertura"> <?php if($voluntario_nome) {} else { ?> Para participar, nos conte quem é você... <?php }; ?> </div>

		<div class="mensagem"> <?php if($msg){ echo $msg; }; ?>	</div>

		<input type="hidden" name="form" value="form_oferta" />
		<input type="hidden" name="email" value="<?php echo $voluntario_email; ?>" />
		<input type="hidden" name="proj" value="<?php echo $projeto; ?>" />

		<dl>
			<dt>
			
				<label for="email">Email</label>
			
			</dt>
			<dd>
				
				<input type="text" id="email_show" name="email_show" value="<?php if($_POST["email"]){echo strip_tags($_POST["email"]);} ?>" <?php if($voluntario_email){echo "disabled";} ?> />
			
			</dd>
		</dl>

		<dl>
			<dt>
			
				<label for="nome">Nome Completo</label>
			
			</dt>
			<dd>
				
				<input type="text" id="nome" name="nome" value="<?php if($voluntario_nome){echo $voluntario_nome;} ?>" />
				
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="telefone">Telefone para contato</label>

			</dt>
			<dd>
				
				<input type="text" id="telefone" name="telefone" value="<?php if($voluntario_telefone){echo $voluntario_telefone;} ?>" />
			
			</dd>
		</dl>

		<ul>

			<div class="abertura">

				Indique qual o tipo de colaboração você pode dar ao projeto...

			</div>

			<li>
				
				<input type="radio" id="trampo" name="oferta" value="trampo" /><label> ajuda / mão-de-obra </label>

			</li>
			<li>
				
				<input type="radio" id="equipo" name="oferta" value="equipo" /><label> empréstimo de equipamento </label>

			</li>
			<li>
				
				<input type="radio" id="local" name="oferta" value="local" /><label> empréstimo de local / espaço </label>

			</li>

		</ul>

		<div id="submit_buttons">

			<button type="submit"> continuar </button>

		</div>

		<div class="fecha">

			Fique tranquilo, seus dados pessoais ficarão ocultos da rede. O BaixoCentro se compromete a nunca repassar
			esses dados para quem quer que seja. Eles só serão disponibilizados depois que você topar participar de um 
			determinado projeto, quando apenas o proponente desse projeto receberá seus contatos, para agilizar o 
			trabalho e as trocas entre vocês.

		</div>

	</form>
	</div>

<?php
		}

/*
 * verifica escolha de tipo de oferta no formulário de voluntário
 * ---------------------------------------------------------------------
 *  */

} 
elseif ($_POST["form"]=="form_oferta") 
{


	if ($_POST["oferta"]=="trampo") 
	{

		/* BD: atualiza Voluntário */
		$connection=mysql_connect($db_host,$db_username,$db_password); if (mysql_errno($connection))  { die("erro: ".__LINE__." | Sem acesso ao MySQL - " . mysql_errno() . ": " . mysql_error() . " .");	}
		$db = mysql_select_db($db_name,$connection); if (!$db) { die("erro: ".__LINE__." | Sem acesso à base de dados - " . mysql_errno() . ": " . mysql_error() . " ."); };
		$query = "SELECT * FROM oferta_voluntarios WHERE email='".$voluntario_email."' LIMIT 1"; 
		$result = mysql_query($query); 
		if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };
		$row = mysql_fetch_row($result);
		if ($row) 
		{
			$voluntario_nome = $row[1];
			$voluntario_telefone = $row[2];
		} 
		else 
		{ 
			die("erro: ".__LINE__." | voluntário não encontrado ."); 
		};
		if ( $voluntario_nome != $_POST["nome"] ) 
		{
			$voluntario_nome = strip_tags($_POST["nome"]);
			$query = "UPDATE oferta_voluntarios SET nome='".$voluntario_nome."'"; 
			$result = mysql_query($query); 
			if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };	
		}
		if ( $voluntario_telefone != $_POST["telefone"] ) 
		{
			$voluntario_telefone = strip_tags($_POST["telefone"]);
			$query = "UPDATE oferta_voluntarios SET telefone='".$voluntario_telefone."'"; 
			$result = mysql_query($query); 
			if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };			
		} 
		/**/

/*
 * 3
 * form TRAMPO
 * ---------------------------------------------------------------------
 *  */
?>

	<div class="form">
	<form method="post" name="form_trampo" id="form_trampo" action="form.php">

		<div class="projeto">

			<b>PROJETO:</b><a href="<?php echo $post_title; ?>"> <?php echo $post_title; ?> </a>

		</div>

		<div class="abertura"> Para participar deste projeto, identifique qual tipo de ajuda abaixo...	</div>

			<input type="hidden" name="form" value="form_identifica" />
			<input type="hidden" name="email" value="<?php echo $voluntario_email; ?>" />
			<input type="hidden" name="proj" value="01" />

		<dl>
			<dt>

				<label for="opcoes">Trampos</label>

			</dt>
			<dd>
				<ul>
					<li>
						
						<input type="checkbox" id="opcoes" name="trampos[]" value="Música" /><label> Atelier/ artes </label>

					</li>
					<li>

							<input type="checkbox" name="trampos[]" value="Vídeo" /><label> Vídeo (técnico) </label>
					</li>
					<li>
						
						<input type="checkbox" name="trampos[]" value="Articulação comunitária" /><label> Articulação comunitária (contato prévio com a vizinhança) </label>

					</li>
					<li>
						
						<input type="checkbox" name="trampos[]" value="Comunicação" /><label> Comunicação (cobertura colaborativa) </label>

					</li>
					<li>
						
						<input type="checkbox" name="trampos[]" value="Cozinha/Comidas" /><label> Cozinha/Comidas </label>

					</li>
					<li>
						
						<input type="checkbox" name="trampos[]" value="Direito" /><label> Direito (formular estratégia + estar pronto para emergência) </label>

					</li>
					<li>
						
						<input type="checkbox" name="trampos[]" value="Produção" /><label> Produção </label>

					</li>
					<li>
						
						<input type="checkbox" name="trampos[]" value="Lixo" /><label> Lixo </label>

					</li>
				</ul>
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="descricao">Outro trampo</label>

			</dt>
			<dd>
				
				<input type="text" id="outros" name="outros" />
			
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="habilidades">Descreva suas habilidades</label>

			</dt>
			<dd>
				
			<textarea id="habilidades" name="habilidades" rows="4" cols="50"></textarea>
			
			</dd>
		</dl>

		<div id="submit_buttons">

			<button type="submit"> enviar </button>

		</div>

	</form>
	</div>

<?php

/*
 * verifica formulário atual
 * ---------------------------------------------------------------------
 *  */
	
	} 
	elseif ($_POST["oferta"]=="equipo") 
	{

		/* BD: atualiza Voluntário */
		$connection=mysql_connect($db_host,$db_username,$db_password); if (mysql_errno($connection))  { die("erro: ".__LINE__." | Sem acesso ao MySQL - " . mysql_errno() . ": " . mysql_error() . " .");	}
		$db = mysql_select_db($db_name,$connection); if (!$db) { die("erro: ".__LINE__." | Sem acesso à base de dados - " . mysql_errno() . ": " . mysql_error() . " ."); };
		$query = "SELECT * FROM oferta_voluntarios WHERE email='".$voluntario_email."' LIMIT 1"; 
		$result = mysql_query($query); 
		if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };
		$row = mysql_fetch_row($result);
		if ($row) 
		{
			$voluntario_nome = $row[1];
			$voluntario_telefone = $row[2];
		} else { 
			die("erro: ".__LINE__." | voluntário não encontrado ."); 
		};
		if ( $voluntario_nome != strip_tags($_POST["nome"]) ) 
		{
			$voluntario_nome = strip_tags($_POST["nome"]);
			$query = "UPDATE oferta_voluntarios SET nome='".$voluntario_nome."'"; 
			$result = mysql_query($query); 
			if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };	
		}
		if ( $voluntario_telefone != $_POST["telefone"] ) 
		{
			$voluntario_telefone = strip_tags($_POST["telefone"]);
			$query = "UPDATE oferta_voluntarios SET telefone='".$voluntario_telefone."'"; 
			$result = mysql_query($query); 
			if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };			
		} 
		/**/

/*
 * 4
 * form EQUIPO
 * ---------------------------------------------------------------------
 *  */
?>

	<div class="form">
	<form method="post" name="form_equipo" id="form_equipo" action="form.php">

		<div class="projeto">

			<b>PROJETO:</b><a href="<?php echo $post_title; ?>"> <?php echo $post_title; ?> </a>

		</div>

		<div class="abertura"> Para emprestar um equipamento para este projeto, identifique-o abaixo... </div>

			<input type="hidden" name="form" value="form_identifica" />
			<input type="hidden" name="email" value="<?php echo $voluntario_email; ?>" />
			<input type="hidden" name="proj" value="01" />

		<dl>
			<dt>

				<label for="opcoes">Tipo de equipamento</label>

			</dt>
			<dd>
				<ul>
					<li>
						
						<input type="checkbox" name="equipos[]" value="música" /><label> música (cabos, caixas, microfones, retornos, palcos, tudo!!) </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="vídeo" /><label> vídeo ( projetor, telas, computador) </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="energia" /><label> energia (cabos, gerador, ponto de luz no BaixoCentro) </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="cobertura" /><label> cobertura (tendas, gazebos, lonas, coberturas) </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="ferramentas" /><label> ferramentas (se ele precisa de algo pra construir) </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="papelaria" /><label> papelaria </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="transporte" /><label> transporte (veículos + mão de obra!) </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="tinta" /><label> tinta </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="infra" /><label> infra (material de construção) </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="mobiliário" /><label> mobiliário </label>

					</li>
					<li>
						
						<input type="checkbox" name="equipos[]" value="iluminação" /><label> iluminação </label>

					</li>
				</ul>
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="descricao">Outro tipo de equipamento</label>

			</dt>
			<dd>
				
				<input type="text" id="outros" name="outros" />
			
			</dd>
		</dl>
		<dl>
			<dt>

				<label for="habilidades">Descreva o equipamento</label>

			</dt>
			<dd>
				
			<textarea id="descricao" name="descricao" rows="4" cols="50"></textarea>
			
			</dd>
		</dl>

		<dl>
			<dt>
			
				<label for="entregar">Você pode entregar?</label>
			
			</dt>
			<dd>			
				<ul>
					<li>
				
						<input type="radio" id="entregar" name="entregar" value="1" /><label> sim </label>

					</li>
					<li>
						
						<input type="radio" id="entregar" name="entregar" value="0" /><label> não </label>

					</li>
				</ul>
			</dd>
		</dl>

		<div>

			Se 'sim', aguarde e entraremos em contato. Se 'não', indique no campo abaixo o endereço e horário disponível para retirada.

		</div>

		<dl>
			<dt>

				<label for="data">data</label>

			</dt>
			<dd>
				
				<input type="text" id="data_retirada" name="data_retirada" />
			
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="endereco">endereco</label>

			</dt>
			<dd>
				
				<input type="text" id="endereco" name="end_retirada" />
				
			</dd>
		</dl>

		<div id="submit_buttons">

			<button type="submit">enviar</button>

		</div>

		</form>
		</div>

<?php

/*
 * verifica formulário atual
 * ---------------------------------------------------------------------
 *  */

	} 
	elseif ($_POST["oferta"]=="local") 
	{

		/* BD: atualiza Voluntário */
		$connection=mysql_connect($db_host,$db_username,$db_password); if (mysql_errno($connection))  { die("erro: ".__LINE__." | Sem acesso ao MySQL - " . mysql_errno() . ": " . mysql_error() . " .");	}
		$db = mysql_select_db($db_name,$connection); if (!$db) { die("erro: ".__LINE__." | Sem acesso à base de dados - " . mysql_errno() . ": " . mysql_error() . " ."); };
		$query = "SELECT * FROM oferta_voluntarios WHERE email='".$voluntario_email."' LIMIT 1"; 
		$result = mysql_query($query); 
		if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };
		$row = mysql_fetch_row($result);
		if ($row) 
		{
			$voluntario_nome = $row[1];
			$voluntario_telefone = $row[2];
		} 
		else 
		{ 
			die("erro: ".__LINE__." | voluntário não encontrado ."); 
		};
		if ( $voluntario_nome != $_POST["nome"] ) 
		{
			$voluntario_nome = strip_tags($_POST["nome"]);
			$query = "UPDATE oferta_voluntarios SET nome='".$voluntario_nome."'"; 
			$result = mysql_query($query); 
			if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };	
		}
		if ( $voluntario_telefone != $_POST["telefone"] ) 
		{
			$voluntario_telefone = strip_tags($_POST["telefone"]);
			$query = "UPDATE oferta_voluntarios SET telefone='".$voluntario_telefone."'"; 
			$result = mysql_query($query); 
			if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };			
		} 
		/**/

/*
 * 5
 * form LOCAL
 * ---------------------------------------------------------------------
 *  */
?>

	<div class="form">
	<form method="post" name="form_lugar" id="form_lugar" action="form.php">

		<div class="projeto">

			<b>PROJETO:</b><a href="<?php echo $post_title; ?>"> <?php echo $post_title; ?> </a>

		</div>

		<div class="abertura"> Para emprestar um local para este projeto, identifique-o abaixo... </div>

			<input type="hidden" name="form" value="form_identifica" />
			<input type="hidden" name="email" value="<?php echo $voluntario_email; ?>" />
			<input type="hidden" name="proj" value="01" />

		<dl>
			<dt>

				<label for="opcao">Tipo de local / espaço</label>

			</dt>
			<dd>
				<ul>
					<li>
						
						<input type="checkbox" name="locais[]" value="Atelier/ artes" /><label> Atelier/ artes </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Auditório" /><label> Auditório </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Banheiro" /><label> Banheiro </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Biblioteca" /><label> Biblioteca </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Cozinha" /><label> Cozinha </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Estúdio de música" /><label> Estúdio de música </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Piscina" /><label> Piscina </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Quintal" /><label> Quintal </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Sala de aula" /><label> Sala de aula </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Sala de dança" /><label> Sala de dança </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Sala de exposição/galeria" /><label> Sala de exposição/galeria </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Sala de reunião" /><label> Sala de reunião </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Sala pra ensaio" /><label> Sala pra ensaio </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Sala de vídeo" /><label> Sala de vídeo (Ilha de edição) </label>

					</li>
					<li>
						
						<input type="checkbox" name="locais[]" value="Salas extras" /><label> Salas extras </label>

					</li>
				</ul>
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="descricao">Outro tipo de local / espaço</label>

			</dt>
			<dd>
				
				<input type="text" id="outros" name="outros" />
			
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="nome">Nome do local</label>

			</dt>
			<dd>
				
				<input type="text" id="nome" name="nome" />
				
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="endereco">Endereco do local</label>

			</dt>
			<dd>
				
				<input type="text" id="endereco" name="endereco" />
				
			</dd>
		</dl>

		<dl>
			<dt>
			
				<label for="capacidade">Capacidade do local</label>
			
			</dt>
			<dd>
				
				<input type="text" id="capacidade" name="capacidade" />
				
			</dd>
		</dl>

		<dl>
			<dt>
			
				<label for="datas">Datas</label>
			
			</dt>
			<dd>
				
				<input type="text" id="datas" name="datas" />
				
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="descricao">Descreva o espaço</label>

			</dt>
			<dd>
				
			<textarea id="descricao" name="descricao" rows="4" cols="50"></textarea>
			
			</dd>
		</dl>

		<dl>
			<dt>
			
				<label for="estacionamento">Possui estacionamento?</label>
			
			</dt>
			<dd>
				<ul>
					<li>
						
						<input type="checkbox" id="estacionamento" name="estacionamento" value="1" /><label> sim </label>

					</li>
					<li>
						
						<input type="checkbox" id="estacionamento" name="estacionamento" value="0" /><label> nao </label>

					</li>
				</ul>
			</dd>
		</dl>

		<dl>
			<dt>

				<label for="atende_def">Atende pessoas com deficiência? Descreva as condições:</label>

			</dt>
			<dd>
				
			<textarea id="def" name="atende_def" rows="4" cols="50"></textarea>
			
			</dd>
		</dl>

		<div id="submit_buttons">

			<button type="submit">enviar</button>

		</div>
	
	</form>
	</div>

<?php

/*
 * atualiza Voluntário
 * ---------------------------------------------------------------------
 *  */


	}	
	else 
	{

		/* BD: atualiza Voluntário */
		$connection=mysql_connect($db_host,$db_username,$db_password); if (mysql_errno($connection))  { die("erro: ".__LINE__." | Sem acesso ao MySQL - " . mysql_errno() . ": " . mysql_error() . " .");	}
		$db = mysql_select_db($db_name,$connection); if (!$db) { die("erro: ".__LINE__." | Sem acesso à base de dados - " . mysql_errno() . ": " . mysql_error() . " ."); };
		$query = "SELECT * FROM oferta_voluntarios WHERE email='".$voluntario_email."' LIMIT 1"; 
		$result = mysql_query($query); 
		if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };
		$row = mysql_fetch_row($result);
		if ($row) 
		{
			$voluntario_nome = $row[1];
			$voluntario_telefone = $row[2];
		} 
		else 
		{ 
			die("erro: ".__LINE__." | voluntário não encontrado ."); 
		};
		if ( $voluntario_nome != $_POST["nome"] ) 
		{
			$voluntario_nome = strip_tags($_POST["nome"]);
			$query = "UPDATE oferta_voluntarios SET nome='".$voluntario_nome."'"; 
			$result = mysql_query($query); 
			if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };	
		}
		if ( $voluntario_telefone != $_POST["telefone"] ) 
		{
			$voluntario_telefone = strip_tags($_POST["telefone"]);
			$query = "UPDATE oferta_voluntarios SET telefone='".$voluntario_telefone."'"; 
			$result = mysql_query($query); 
			if (mysql_errno()) { die("erro: ".__LINE__." | " . mysql_errno() . ": " . mysql_error() . " ."); };			
		} 
		/**/
		die ("seus dados foram atualizados. Se quiser, você pode especificar o tipo de ajuda escolha uma das opções");

	};
/*
 * finaliza
 *  */
} 
else 
{

 die("erro: ".__LINE__." | final do script .");

}
?>

</body>
</html>

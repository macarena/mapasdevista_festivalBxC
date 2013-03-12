#Mapas de Vista Festival BaixoCentro
====================================

Este é um fork do tema Mapas de Vista do WP, feito para o Festival BaixoCentro.
Para utilizar o tema, siga as instruções:

1. Instale o wordpress 3.5.1 - http://br.wordpress.org/wordpress-3.5.1-pt_BR.tar.gz
2. crie o arquivo wp-config seguinte as instruções do Wordpress.
3. baixe e extraia na pasta wp-content os arquivos festival.baixocentro.org/mapa/wp-content/plugins.tar.gz e uploads.tar.gz (Obs: deixe para baixar o uploads somente se for muito necessário ver as imagens dos posts ou os pins. Ou então, use outras imagens na sua instalação)
3. baixo o dump do banco de dados em: festival.baixocentro.org/mapa/dump_festival2013mapa.sql
4. Altere na tabela wp_options (ou outro prefixo), as linhas com o campo option_name como 'siteurl' e 'home' para o seu caminho de instalação co wordpress. Ex.: localhost/wordpress
5. clone esse git dentro da pasta wp-content/themes/
5. Entre no seu Painel de Administração do WP (o site não vai funcionar ainda, não se assuste) e altere o tema para o mapasdevista_festivalBxC
6. Supimpa! Seu WP está funfando exatamente como no site.

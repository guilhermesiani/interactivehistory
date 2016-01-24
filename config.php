<?php
// Configuração do Fuso Horário
date_default_timezone_set('America/Sao_Paulo');

// Sempre use barra (/) no final das URLs
define('URL', 'http://localhost:9090/');
define('LIBS', 'libs/');

// Configuração com Banco de Dados
define('DB_TYPE', 'pgsql');
define('DB_HOST', 'ec2-54-204-35-207.compute-1.amazonaws.com:5432');
define('DB_NAME', 'd8c3c37jnpnctg');
define('DB_USER', 'afgtyzbfzprnjq');
define('DB_PASS', '3Tf4dZgvid5ANZQE3JuUFReGNl');

// HASH KEY, nunca mude esta parte, pois é usada para as senhas!
define('HASH_GENERAL_KEY', 'MixitUp200');

// Isto é apenas para o Banco de Dados
define('HASH_PASSWORD_KEY', 'catsFLYhigh2000miles');

// Configuração de Imagens
define('IMG_FOLDER', 'images/'); // Pasta das imagens sempre com "/" no final
define('IMG_SIZE', '1000000'); // Tamanho máximo do arquivo em bytes

// Outros
define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', realpath(__DIR__.DS));
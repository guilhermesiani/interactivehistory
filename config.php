<?php
// Configuração do Fuso Horário
date_default_timezone_set('America/Sao_Paulo');

// Sempre use barra (/) no final das URLs
define('URL', 'http://localhost:9090/');
define('LIBS', 'libs/');

// Configuração com Banco de Dados
define('DB_TYPE', 'pgsql');
define('DB_HOST', 'ec2-54-197-224-155.compute-1.amazonaws.com:5432');
define('DB_NAME', 'd9t6vfbngfu0r4');
define('DB_USER', 'xswjdizupkmude');
define('DB_PASS', 'srZ59DLILkk_SYyNaMAp1HeWB2');

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
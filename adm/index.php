<?php
session_start();
ob_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
/*
error_reporting(E_ALL);
error_reporting(E_WARNING);
error_reporting(E_NOTICE);
error_log("Write this error down to a file!", 3, "./all_errors.log");
*/

//Carregar o composer
require './vendor/autoload.php';

//Em vez de chamar pelo  nome(Core) e sobrenome(ConfigController), chame pelo apelido(Home)
//Atribuindo o apelido "Home" para rota da classe "core/ConfigController"
use Core\ConfigController as Home;

//Logo que a página é carregada, é instanciado um objeto ConfigController
//$url = new Core\ConfigController();
//instanciando a classe utilizando um apelido
$url = new Home();

//instanciando o método
$url->carregar();

/*$home = new ConfigController(); $home->carregar();*/
        
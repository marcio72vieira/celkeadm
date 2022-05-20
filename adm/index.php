<?php
session_start();
ob_start();

require './vendor/autoload.php';

//Em vez de chamar pelo  nome(Core) e sobrenome(ConfigController), chame pelo apelido(Home)
use Core\ConfigController as Home;

//Logo que a página é carregada, é instanciado um objeto ConfigController
//$url = new Core\ConfigController();
$url = new Home();
$url->carregar();

/*$home = new ConfigController(); $home->carregar();*/
        
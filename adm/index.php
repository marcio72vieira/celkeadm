<?php
session_start();
ob_start();

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
        
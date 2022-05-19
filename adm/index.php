<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>CelkeADM</title>
    </head>
    <body>
        <?php
            require './vendor/autoload.php';
            
            //Em vez de chamar pelo  nome(Core) e sobrenome(ConfigController), chame pelo apelido(Home)
            use Core\ConfigController as Home;
            
            //Logo que a página é carregada, é instanciado um objeto ConfigController
            //$url = new Core\ConfigController();
            $url = new Home();
            $url->carregar();
            
            /*$home = new ConfigController();
            $home->carregar();*/
        ?>
    </body>
</html>

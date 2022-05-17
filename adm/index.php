<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>CelkeADM</title>
    </head>
    <body>
        <?php
            require './vendor/autoload.php';
            
            use Core\ConfigController as Home;
            
            //$url = new Core\ConfigController();
            $url = new Home();
            $url->carregar();
            
            /*$home = new ConfigController();
            $home->carregar();*/
        ?>
    </body>
</html>

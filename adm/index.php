<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>CelkeADM</title>
    </head>
    <body>
        <?php
            require './vendor/autoload.php';
            
            $url = new Core\ConfigController();
            $url->carregar();
            
            $home = new ConfigController();
            $home->carregar();
        ?>
    </body>
</html>

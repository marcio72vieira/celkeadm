<?php

abstract class Config {

    protected function configAdm() {
        define('URL', 'http://localhost/celkeadm/');
        define('URLADM', 'http://localhost/celkeadm/adm/');

        define('CONTROLLER', 'Login');
        define('METODO', 'access');
        define('CONTROLLERERRO', 'Erro');
    }

}

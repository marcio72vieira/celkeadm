<?php

namespace Core;

abstract class Config {

    protected function configAdm() {
        define('URL', 'http://localhost/celkeadm/');
        define('URLADM', 'http://localhost/celkeadm/adm/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        define('CONTROLLERERRO', 'Erro');
        
        define('EMAILADM', 'marcio@seati.ma.gov.br');
        
        //Credenciais de acesso ao Banco de Dados
        define('DB', 'mysql');
        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', 'marcio72');
        define('DBNAME', 'celkeadm');
        define('PORT', 3306);
        
        // echo "<pre>"; var_dump("Script: xxxxxxxx, Linha: xxxx ", $this->xxxxxxx); echo "</pre>";
        
    }

}

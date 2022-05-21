<?php

namespace App\adms\Models\helper;

use PDO;
use Exception;

class AdmsConn {
    private string $db = DB;
    private string $host = HOST;
    private string $user = USER;
    private string $pass = PASS;
    private string $dbName = DBNAME;
    private int $port = PORT;
    public object $connect;

    protected function connect() {
        try{
            $this->connect = new PDO("{$this->db}:host={$this->host};port={$this->port};dbname=".$this->dbName, $this->user, $this->pass);
            //echo "Conexão...Ok!";
            return $this->connect;
        }catch(Exception $ex){
            die('Erro (Conexão): Por favor tente novamente. Caso o erro persista entre em contato com o administrador: '. EMAILADM .'<br>');
        }
    }

}

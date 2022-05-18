<?php

namespace App\adms\Models;

class admsLogin extends helper\admsConn {

    private array $dados;
    private object $conn;

    public function login(array $dados = null) {
        $this->dados = $dados;
        echo "<pre>";
            var_dump("dados do método login() ", $this->dados); 
        echo "</pre>";
        
        $this->conn = $this->connect();
        echo "<pre>";
            var_dump("dados do método login() ", $this->conn); 
        echo "</pre>";
    }

}

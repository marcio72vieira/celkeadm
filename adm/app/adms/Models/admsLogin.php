<?php

namespace App\adms\Models;

use PDO;

class admsLogin extends helper\admsConn {

    private array $dados;
    private object $conn;
    private $resultadoBd;
    private $resultado;
    
    
    public function getResultado() {
        return $this->resultado;
    }

    
    public function login(array $dados = null) {
        $this->dados = $dados;
        echo "<pre>"; var_dump("dados do método login() ", $this->dados); echo "</pre>";
        
        $this->conn = $this->connect();
        echo "<pre>"; var_dump("dados do método login() ", $this->conn); echo "</pre>";
        
        $query_val_login = "SELECT id, name, nickname, email, password, image FROM adms_users WHERE user =:user LIMIT 1";
        $result_val_login = $this->conn->prepare($query_val_login);
        $result_val_login->bindParam(':user', $this->dados['user'], PDO::PARAM_STR);
        $result_val_login->execute();
        
        $this->resultadoBd = $result_val_login->fetch();
        
        echo "<pre>"; var_dump("Dados do banco...: ", $this->resultadoBd); echo "</pre>";
        
        if($this->resultadoBd) {
            return $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Usuário não encontrado!<br><br>";
            return $this->resultado = false;
        }
 
    }

}

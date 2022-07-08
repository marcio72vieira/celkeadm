<?php

namespace App\adms\Models;

//use PDO;

class AdmsListUsers {

    private $resultadoBd;
    private $resultado;

    public function getResultado() {
        return $this->resultado;
    }
    
    public function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function listUsers() {

        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("SELECT id, name, email FROM adms_users");

        $this->resultadoBd = $listUsers->getResult();

        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Nenhum usuário encontrado!<br>";
            return $this->resultado = false;
        }
    }

}

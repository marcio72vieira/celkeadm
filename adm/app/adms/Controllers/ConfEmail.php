<?php

namespace App\adms\Controllers;

class ConfEmail {
    
    private $chave;
    
    public function index() {
        
        $this->chave = filter_input(INPUT_GET, "chave", FILTER_DEFAULT);
        
        //Se a chave for diferente de vazio
        if(!empty($this->chave)) {
            echo "Chave: {$this->chave}<br>";
            $this->validarCharve();
        } else {
            $_SESSION['msg'] = "Erro: Link, inválido!";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }
    
    private function validarCharve() {
        $confEmail = new \App\adms\Models\AdmsConfEmail();
        $confEmail->confEmail($this->chave);
        
        if($confEmail->getResultado()) {
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        } else {
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }
}

<?php

namespace App\adms\Controllers;

class UpdatePassword {
    
    private $chave;
    private $dados;
    private $dadosForm;
    
    public function index() {
        $this->chave = filter_input(INPUT_GET, "chave", FILTER_DEFAULT);
        //Se a chave for diferente de vazio, significa que o usuário cliclou no link do email enviado
        if(!empty($this->chave)) {
            //Verificar se a chave é válida
            $this->validarChave();
            
        } else {
            echo "Sem a chave<br>";
        }
    }
    
    private function validarChave() {
        $valChave = new \App\adms\Models\AdmsUpdatePassword();
        $valChave->validarChave($this->chave);
        
        if($valChave->getResultado()) {
            $carregarView = new \Core\ConfigView("adms/Views/login/updatePassword");
            $carregarView->renderizar();
        } else {
            $urlDestino = URLADM ."login/index";
            header("Location: $urlDestino");
        }
        
        
        
    }
}

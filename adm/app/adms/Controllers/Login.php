<?php

namespace App\adms\Controllers;

class Login {
    
    private $dados;
    private $dadosForm;
    
    public function access() {
        
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(!empty($this->dadosForm['sendLogin'])){
            $valLogin = new \App\adms\Models\admsLogin();
            $valLogin->login($this->dadosForm);
            
            $this->dados['form'] = $this->dadosForm;
        }
        
        //Como o construtor da view a ser chamada recebe $dados que é um array, temos que passar um array mesmo que vazio
        //$this->dados = [];
        
        $carregarView = new \Core\ConfigView("adms/Views/login/access", $this->dados);
        $carregarView->renderizar();
        
    }
}

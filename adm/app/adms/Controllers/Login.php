<?php

namespace App\adms\Controllers;

class Login {
    
    private $dados;
    private $dadosForm;
    
    public function index() {
        
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //Se "sendLogin" for diferente de vezio, ou seja, se o botão sendLogin foi enviado, clicado, ele existirá, logo será instanciada a Model
        if(!empty($this->dadosForm['sendLogin'])){
            $valLogin = new \App\adms\Models\AdmsLogin();
            $valLogin->login($this->dadosForm);
            
            if($valLogin->getResultado()){
                $urlDestino = URLADM. "dashboard/index";
                header("Location: {$urlDestino}");
                //echo "Redirecionar o usuário para o Painel ADMINISTRATIVO!<br>";
            } else {
                $this->dados['form'] = $this->dadosForm;
            }
        }
        
        //Como o construtor da view a ser chamada recebe $dados que é um array, temos que passar um array mesmo que vazio
        //$this->dados = [];
        
        //Chamando o nome da View e passando os dados, caso haja
        $carregarView = new \Core\ConfigView("adms/Views/login/access", $this->dados);
        $carregarView->renderizar();
        
    }
}

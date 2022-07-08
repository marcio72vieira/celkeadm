<?php

namespace App\adms\Controllers;

class RecoverPassword {
    
    private $dados;
    private $dadosForm;
    
    public function index() {
        
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Se "recoverPassword" for diferente de vazio, ou seja, se o botão recoverPassword foi enviado, clicado, ele existirá, logo será instanciada a Model
        //caso contrário, ele carregará a view para enviar um novo link para configurar email
        if(!empty($this->dadosForm['recoverPassword'])){
            unset($this->dadosForm['recoverPassword']);
            $recoverPassword = new \App\adms\Models\AdmsRecoverPassword();
            $recoverPassword->recoverPassword($this->dadosForm);
            
            if($recoverPassword->getResultado()){
                $urlDestino = URLADM. "login/index";
                header("Location: {$urlDestino}");
                //echo "Redirecionar o usuário para o Painel ADMINISTRATIVO!<br>";
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewRecoverPass();
            }
        }else {
             $this->viewRecoverPass();
        }
        
        //Como o construtor da view a ser chamada recebe $dados que é um array, temos que passar um array mesmo que vazio
        //$this->dados = [];
        
         
    }
    
    private function viewRecoverPass() {
        //Chamando o nome da View e passando os dados, caso haja
        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/recoverPassword", $this->dados);
        $carregarView->renderizarLogin();
        
    }
}

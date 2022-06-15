<?php

namespace App\adms\Controllers;

class NewConfEmail {
    
    private $dados;
    private $dadosForm;
    
    public function index() {
        
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Se "newConfEmail" for diferente de vazio, ou seja, se o botão newConfEmail foi enviado, clicado, ele existirá, logo será instanciada a Model
        //caso contrário, ele carregará a view para enviar um novo link para configurar email
        if(!empty($this->dadosForm['newConfEmail'])){
            $newConfEmail = new \App\adms\Models\AdmsNewConfEmail();
            $newConfEmail->newConfEmail($this->dadosForm);
            
            if($newConfEmail->getResultado()){
                $urlDestino = URLADM. "login/index";
                header("Location: {$urlDestino}");
                //echo "Redirecionar o usuário para o Painel ADMINISTRATIVO!<br>";
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewNewConfEmail();
            }
        }else {
             $this->viewNewConfEmail();
        }
        
        //Como o construtor da view a ser chamada recebe $dados que é um array, temos que passar um array mesmo que vazio
        //$this->dados = [];
        
         
    }
    
    private function viewNewConfEmail() {
        //Chamando o nome da View e passando os dados, caso haja
        $carregarView = new \Core\ConfigView("adms/Views/login/newConfEmail", $this->dados);
        $carregarView->renderizar();
        
    }
}

<?php

namespace App\adms\Controllers;

class NewUser {
    
    private $dados;
    private $dadosForm;
    
    public function index() {
        
        //Recebe os dados (campos, inclusive o botão) vindos do formulário contido na view abaixo, que é submetido para esta própria página
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Verifica se o usuário cliclou no botão SendNewUser do formulário. Caso contrário, carrega a view (formulário)
        if (!empty($this->dadosForm['SendNewUser'])) {
            unset($this->dadosForm['SendNewUser']);
            $createNewUser = new \App\adms\Models\AdmsNewUser();
            $createNewUser->create($this->dadosForm);
            
            if($createNewUser->getResultado()) {
                $urlDestino = URLADM. "login/index";
                header("Location: $urlDestino");
            } else {
                //Se não foi cadastrado com sucesso, mantém os dados no formulário e carrega a view
                $this->dados['form'] = $this->dadosForm;
                $this->viewNewUser();
            }
            
            
            
        } else {
            $this->viewNewUser();
        }
    }
    
    public function viewNewUser() {
        //Instanciando o objeto view, através da classe ConfigView. Obs: o objeto ConfigView.php está no "diretório"
        //core, mas a view que ele recebe como parâmetro, está no "diretório" app/adms/View/login/newUser. O "app" inicial
        //é colocado, através de uma concatenação, lá no método renderizar() da classe Core\ConfigView.php
        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/newUser", $this->dados);
        $carregarView->renderizarLogin();
    }
}

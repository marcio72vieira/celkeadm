<?php

namespace App\adms\Controllers;

class AddUsers {
    
    private $dados;
    private $dadosForm;
    
    public function index() {
        
        //Recebe os dados (campos, inclusive o botão) vindos do formulário contido na view abaixo, que é submetido para esta própria página
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Verifica se o usuário cliclou no botão AddUser do formulário. Caso contrário, carrega a view (formulário)
        if (!empty($this->dadosForm['AddUser'])) {
            unset($this->dadosForm['AddUser']);
            $addUser = new \App\adms\Models\AdmsAddUsers();
            $addUser->create($this->dadosForm);
            
            if($addUser->getResultado()) {
                $urlDestino = URLADM. "list-users/index";
                header("Location: $urlDestino");
            } else {
                //Se não foi cadastrado com sucesso, mantém os dados no formulário e carrega a view
                $this->dados['form'] = $this->dadosForm;
                $this->viewAddUser();
            }
            
            
            
        } else {
            $this->viewAddUser();
        }
    }
    
    public function viewAddUser() {
        //Instanciando o objeto view, através da classe ConfigView. Obs: o objeto ConfigView.php está no "diretório"
        //core, mas a view que ele recebe como parâmetro, está no "diretório" app/adms/View/login/newUser. O "app" inicial
        //é colocado, através de uma concatenação, lá no método renderizar() da classe Core\ConfigView.php
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/addUser", $this->dados);
        $carregarView->renderizarLogin();
    }
}

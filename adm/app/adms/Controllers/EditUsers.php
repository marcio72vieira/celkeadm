<?php


namespace App\adms\Controllers;


class EditUsers {
    
    private $dados;
    private $dadosForm;
    private int $id;
    
    
    public function index($id) {
        $this->id = (int) $id;
        
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Verifica se está vindo o ID na URL e o usuário não está tentando editar. Se o resultado desta
        //verificação for false, o usuário está tentando editar e aí executa o ele desta condição
        if(!empty($this->id) AND empty($this->dadosForm['EditUser'])) {
            echo "Só cliquei no link de edit!<br>";
            $viewUser =  new \App\adms\Models\AdmsEditUsers();
            $viewUser->viewUser($this->id);
            if($viewUser->getResultado()) {
                $this->dados['form'] =  $viewUser->getResultadoBd();
                $this->viewEditUser();
            } else {
                $urlDestino = URLADM ."list-users/index";
                header("Location: $urlDestino");
            }
        } else {
                echo "O botão EditUser/Salvar foi acionado! Então é acionado o método editUser()<br>";
                $this->editUser();
                
        }  
    }
    
    private function viewEditUser() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editUser", $this->dados);
        $carregarView->renderizar();
    }
    
    private function editUser() {
        if(!empty($this->dadosForm['EditUser'])) {
            unset($this->dadosForm['EditUser']);
            $editUser =  new \App\adms\Models\AdmsEditUsers();
            $editUser->update($this->dadosForm);
            if($editUser->getResultado()) {
                $urlDestino = URLADM ."list-users/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditUser();
            }
        } else {
            $_SESSION['msg'] = "Usuário não encontrado!<br>";
            $urlDestino = URLADM ."list-users/index";
            header("Location: $urlDestino");
        }
    }
}

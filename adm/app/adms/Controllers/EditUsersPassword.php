<?php


namespace App\adms\Controllers;


class EditUsersPassword {
    
    private $dados;
    private $dadosForm;
    private int $id;
    
    
    public function index($id) {
        $this->id = (int) $id;
        
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Se for diferente de vazio e não está vindo do formulário, significa que o usuário está tentando acessar
        //a página editar
        //Obs: quando o usuário clicar no link "Editar Senha", localizado na view: viewUser (que mostra os detalhes
        //do usuário), o valor da condição abaixo, será verdadeiro, visto que o $id não é vazio (true), pois veio pela
        //URL e o valor da sentença empt($this->dadosForm['EditUserPass] será true, isto porque em um primeiro
        //momento o usuário não clicou no botão de EdtiUserPass quando da visuaçização do formulário. 
        if(!empty($this->id) AND empty($this->dadosForm['EditUserPass'])) {
            $viewUserPass =  new \App\adms\Models\AdmsEditUsersPassword();
            $viewUserPass->viewUser($this->id);
            if($viewUserPass->getResultado()) {
                $this->dados['form'] =  $viewUserPass->getResultadoBd();
                $this->viewEditUserPass();
            } else {
                $urlDestino = URLADM ."list-users/index";
                header("Location: $urlDestino");
            }
        } else {
                $this->editUserPass();
                
        }  
    }
    
    private function viewEditUserPass() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editUserPassword", $this->dados);
        $carregarView->renderizar();
    }
    
    private function editUserPass() {
        if(!empty($this->dadosForm['EditUserPass'])) {
            unset($this->dadosForm['EditUserPass']);
            $editUserPass =  new \App\adms\Models\AdmsEditUsersPassword();
            $editUserPass->update($this->dadosForm);
            if($editUserPass->getResultado()) {
                $urlDestino = URLADM ."list-users/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditUserPass();
            }
        } else {
            $_SESSION['msg'] = "Usuário não encontrado!<br>";
            $urlDestino = URLADM ."list-users/index";
            header("Location: $urlDestino");
        }
    }
}

<?php

namespace App\adms\Controllers;

class UpdatePassword {
    
    private $chave;
    private $dadosForm;
    
    public function index() {
        //Recebe a chave enviada pelo link do email enviado ao usuário
        $this->chave = filter_input(INPUT_GET, "chave", FILTER_DEFAULT);
        //Recebe os dados do formulário da view updatePassword
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Se a chave for diferente de vazio, significa que o usuário cliclou no link do email enviado
        //Verifica se a chave é diferente de vazio, ou seja, foi enviada via click do link no email enviado ao
        //usuário e se dadosForm é vazio, ou seja, quando nao está enviando os dados do formulário só é preciso validar
        //a chave. Agora quando vem dados do formulário, não é preciso validar a chave.

        if(!empty($this->chave) AND empty($this->dadosForm['upPassword'])) {
            //Verificar se a chave é válida
            $this->validarChave();
        } else {
            //echo "Sem a chave<br>";
            $this->updatePassword();
        }
    }
    
    private function validarChave() {
        $valChave = new \App\adms\Models\AdmsUpdatePassword();
        $valChave->validarChave($this->chave);
        
        if($valChave->getResultado()) {
            $this->viewUpdatePassword();
        } else {
            $urlDestino = URLADM ."login/index";
            header("Location: $urlDestino");
        }
    }
    
    private function updatePassword() {
        if(!empty($this->dadosForm['upPassword'])) {
            unset($this->dadosForm['upPassword']);
            
            $this->dadosForm['chave'] = $this->chave;
            
            $upPassword = new \App\adms\Models\AdmsUpdatePassword();
            $upPassword->editPassword($this->dadosForm);    //Enviando um array não apenas uma posição do array
            
            if($upPassword->getResultado()) {
                 $urlDestino = URLADM ."login/index";
                header("Location: $urlDestino");
            } else {
                $this->viewUpdatePassword();
            }
            
        } else {
            $_SESSION['msg'] = "Erro: Link inválido, solicite novo link <a href='". URLADM ."recover-password/index'>Clique aqui</a>!<br><br>";
            $urlDestino = URLADM ."login/index";
            header("Location: $urlDestino");
        }
    }
    
    private function viewUpdatePassword() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/login/updatePassword");
        $carregarView->renderizarLogin();
    }
}

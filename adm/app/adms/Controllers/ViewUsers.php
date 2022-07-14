<?php

namespace App\adms\Controllers;

class ViewUsers {

    private int $id;
    private $dados;

    public function index($id) {
        $this->id = (int) $id;
        //echo "Ver usuário {$this->id}<br>";

        //Verifica se o usuário está enviando um id na URL
        if (!empty($this->id)) {
            $viewUser = new \App\adms\Models\AdmsViewUsers();
            $viewUser->viewUser($this->id);
            if ($viewUser->getResultado()) {
                $this->dados['viewUser'] = $viewUser->getResultadoBd();
                //Instancia a view
                $this->viewUser();
            } else {
                $urlDestino = URLADM . "list-users/index";
                header("Location: $urlDestino");
            }
        } else {
            $_SESSION['msg'] = "Usuário não encontrado!<br>";
            $urlDestino = URLADM . "list-users/index";
            header("Location: $urlDestino");
        }
    }
    
    private function viewUser() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/viewUser", $this->dados);
        $carregarView->renderizar();
    }

}

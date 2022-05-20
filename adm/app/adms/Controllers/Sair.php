<?php

namespace App\adms\Controllers;

class Sair {

    public function index() {
        //Destrói as variáveis de sessão criadas no model admsLogin, quando o usuário loga no sistema
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_nickname'], $_SESSION['user_email'], $_SESSION['user_image']);

        //Redireciona o usuário
        $_SESSION['msg'] = "Deslogado com sucesso!<br>";
        $urlDestino = URLADM . "login/index";
        header("Location: $urlDestino");
    }

}

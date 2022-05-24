<?php

namespace App\adms\Models;

//use PDO;

class AdmsNewUser extends helper\AdmsConn {

    private array $dados;
    private $resultado;

    public function getResultado() {
        return $this->resultado;
    }

    public function create(array $dados = null) {
        //Recebe os dados do formulário enviado pelo objeto $createNewUser, no método index() do controller NewUser.php
        $this->dados = $dados;

        //Instancia e invoca a validação de campos
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);

        //Testa a validação de campos
        if ($valCampoVazio->getResultado()) {
            //Criptografando a senha
            $this->dados['password'] = password_hash($this->dados['password'], PASSWORD_DEFAULT);
            $this->dados['user'] = $this->dados['email'];
            $this->dados['created'] = date("Y-m-d H:i:s");

            //Instanciando um objeto do tipo AdmCreate e invocando os seus métodos
            $createUser = new \App\adms\Models\helper\AdmsCreate();
            $createUser->exeCreate("adms_users", $this->dados);

            if ($createUser->getResult()) {
                $_SESSION['msg'] = "Usuário cadastrado com sucesso!<br>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "Erro: Usuário não cadastrado!<br>";
                $this->resultado = false;
            }

        } else {
            $this->resultado = false;
        }
    }

}

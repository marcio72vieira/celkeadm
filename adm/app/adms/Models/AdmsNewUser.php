<?php

namespace App\adms\Models;

//use PDO;

class AdmsNewUser extends helper\AdmsConn {

    private array $dados;
    private object $conn;
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

            //Estabelece a conexão 
            $this->conn = $this->connect();

            //Cria a query com os links para o bindParam
            $query_new_user = "INSERT INTO adms_users (name, email, user, password, created) VALUES (:name, :email, :user, :password, NOW())";

            //Prepara a query
            $add_new_user = $this->conn->prepare($query_new_user);

            //Faz o vínculo entre os links e os valores vindo do formulário. A senha já foi criptografada
            $add_new_user->bindParam(':name', $this->dados['name']);
            $add_new_user->bindParam(':email', $this->dados['email']);
            $add_new_user->bindParam(':user', $this->dados['email']);
            $add_new_user->bindParam(':password', $this->dados['password']);

            //Executa a a queryprepatada
            $add_new_user->execute();

            //Verifica a quantidade de linhas inseridas no banco
            if ($add_new_user->rowCount()) {
                $_SESSION['msg'] = "Erro: Usuário cadastrado com sucesso!<br>";
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

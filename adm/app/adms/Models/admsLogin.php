<?php

namespace App\adms\Models;

use PDO;

class admsLogin extends helper\admsConn {

    private array $dados;
    private object $conn;
    private $resultadoBd;
    private $resultado;

    public function getResultado() {
        return $this->resultado;
    }

    public function login(array $dados = null) {
        $this->dados = $dados;
        echo "<pre>"; var_dump("dados do método login() ", $this->dados); echo "</pre>";

        $this->conn = $this->connect();
        echo "<pre>"; var_dump("dados do método login() ", $this->conn); echo "</pre>";

        $query_val_login = "SELECT id, name, nickname, email, password, image FROM adms_users WHERE user =:user LIMIT 1";
        $result_val_login = $this->conn->prepare($query_val_login);
        $result_val_login->bindParam(':user', $this->dados['user'], PDO::PARAM_STR);
        $result_val_login->execute();

        $this->resultadoBd = $result_val_login->fetch();

        echo "<pre>"; var_dump("Dados do banco...: ", $this->resultadoBd); echo "</pre>";

        if ($this->resultadoBd) {
            $this->validarSenha();
        } else {
            $_SESSION['msg'] = "Erro: Usuário não encontrado!<br><br>";
            return $this->resultado = false;
        }
    }

    private function validarSenha() {
        //Vefifica se o que a senha que o usuário digitou no fomulário é igual a que existe vindo do banco de dados
        if (password_verify($this->dados['password'], $this->resultadoBd['password'])) {
            //Salvando os dados do usuário na sessão
            $_SESSION['user_id'] = $this->resultadoBd['id'];
            $_SESSION['user_name'] = $this->resultadoBd['name'];
            $_SESSION['user_nickname'] = $this->resultadoBd['nickname'];
            $_SESSION['user_email'] = $this->resultadoBd['email'];
            $_SESSION['user_image'] = $this->resultadoBd['image'];

            return $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Usuário e/ou Senha incorreta!<br><br>";
            return $this->resultado = false;
        }
    }

}

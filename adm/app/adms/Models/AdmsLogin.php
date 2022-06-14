<?php

namespace App\adms\Models;

//use PDO;

class AdmsLogin {

    private array $dados;
    private $resultadoBd;
    private $resultado;

    public function getResultado() {
        return $this->resultado;
    }

    public function login(array $dados = null) {
        $this->dados = $dados;
        
        $viewUser =  new \App\adms\Models\helper\AdmsRead();
        //Recupera todas as colunas da tabela (não recomendado)
        //$viewUser->exeRead("adms_users", "WHERE user =:user LIMIT :limit", "user={$this->dados['user']}&limit=1");
        
        //Recupera colunas específicas da tabela (recomendado) e realiza o login utilizando só o nome de usuário
        //$viewUser->fullRead("SELECT id, name, nickname, email, password, image FROM adms_users WHERE username =:username LIMIT :limit", "username={$this->dados['username']}&limit=1");
        //Realiza o login utilizando o usuário ou o email
        $viewUser->fullRead("SELECT id, name, nickname, email, password, adms_sits_user_id, image FROM adms_users WHERE username =:username OR email =:email LIMIT :limit", "username={$this->dados['username']}&email={$this->dados['username']}&limit=1");
        
        $this->resultadoBd = $viewUser->getResult();
        
        //var_dump($viewUser->getResult());
        
        if ($this->resultadoBd) {
            $this->valEmailPerm();
        } else {
            $_SESSION['msg'] = "Erro: Usuário não encontrado!<br><br>";
            return $this->resultado = false;
        }
    }
    
    private function valEmailPerm() {
        if ($this->resultadoBd[0]['adms_sits_user_id'] == 3) {
            $_SESSION['msg'] = "Erro: Necessário confirmar o e-mail!<br><br>";
            return $this->resultado = false;
        } else if ($this->resultadoBd[0]['adms_sits_user_id'] == 5) {
            $_SESSION['msg'] = "Erro: E-mail descadastrado, entre em contato com a empresa!<br><br>";
            return $this->resultado = false;
        } else if ($this->resultadoBd[0]['adms_sits_user_id'] == 2) {
            $_SESSION['msg'] = "Erro: E-mail inativo, entre em contato com a empresa!<br><br>";
            return $this->resultado = false;
        } else {
            $this->validarSenha();
        }
    }

    private function validarSenha() {
        //Vefifica se o que a senha que o usuário digitou no fomulário é igual a que existe vindo do banco de dados
        if (password_verify($this->dados['password'], $this->resultadoBd[0]['password'])) {
            //Salvando os dados do usuário na sessão
            $_SESSION['user_id'] = $this->resultadoBd[0]['id'];
            $_SESSION['user_name'] = $this->resultadoBd[0]['name'];
            $_SESSION['user_nickname'] = $this->resultadoBd[0]['nickname'];
            $_SESSION['user_email'] = $this->resultadoBd[0]['email'];
            $_SESSION['user_image'] = $this->resultadoBd[0]['image'];

            return $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Usuário e/ou Senha incorreta!<br><br>";
            return $this->resultado = false;
        }
    }

}

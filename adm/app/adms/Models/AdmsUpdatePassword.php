<?php

namespace App\adms\Models;

//use PDO;

class AdmsUpdatePassword {

    private $resultadoBd;
    private $resultado;
    private string $chave;
    private array $saveData;

    public function getResultado() {
        return $this->resultado;
    }

    public function validarChave($chave) {
        $this->chave = $chave;

        $viewChaveUpPass = new \App\adms\Models\helper\AdmsRead();
        //Recupera todas as colunas da tabela (não recomendado)
        //$viewUser->exeRead("adms_users", "WHERE user =:user LIMIT :limit", "user={$this->dados['user']}&limit=1");
        //Recupera colunas específicas da tabela (recomendado) e realiza o login utilizando só o nome de usuário
        //$viewUser->fullRead("SELECT id, name, nickname, email, password, image FROM adms_users WHERE username =:username LIMIT :limit", "username={$this->dados['username']}&limit=1");
        //Realiza o login utilizando o usuário ou o email
        $viewChaveUpPass->fullRead("SELECT id 
                FROM adms_users 
                WHERE recover_password =:recover_password 
                LIMIT :limit",
                "recover_password={$this->chave}&limit=1");

        $this->resultadoBd = $viewChaveUpPass->getResult();

        if ($this->resultadoBd) {
            return $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Link inválido, solicite novo link <a href='". URLADM ."recover-password/index'>Clique aqui</a>!<br><br>";
            return $this->resultado = false;
        }
    }

}

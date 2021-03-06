<?php

namespace App\adms\Models;

//use PDO;

class AdmsConfEmail {

    private $resultadoBd;
    private $resultado;
    private string $chave;
    private array $saveData;

    public function getResultado() {
        return $this->resultado;
    }

    public function confEmail($chave) {
        $this->chave = $chave;

        $viewChaveConfEmail = new \App\adms\Models\helper\AdmsRead();
        //Recupera todas as colunas da tabela (não recomendado)
        //$viewUser->exeRead("adms_users", "WHERE user =:user LIMIT :limit", "user={$this->dados['user']}&limit=1");
        //Recupera colunas específicas da tabela (recomendado) e realiza o login utilizando só o nome de usuário
        //$viewUser->fullRead("SELECT id, name, nickname, email, password, image FROM adms_users WHERE username =:username LIMIT :limit", "username={$this->dados['username']}&limit=1");
        //Realiza o login utilizando o usuário ou o email
        $viewChaveConfEmail->fullRead("SELECT id 
                FROM adms_users 
                WHERE conf_email =:conf_email 
                LIMIT :limit",
                "conf_email={$this->chave}&limit=1");

        $this->resultadoBd = $viewChaveConfEmail->getResult();

        if ($this->resultadoBd) {
            $this->updateSitUser();
        } else {
            $_SESSION['msg'] = "Erro: Link inválido (não encontrado)!<br><br>";
            return $this->resultado = false;
        }
    }

    private function updateSitUser() {

        $this->saveData['conf_email'] = null;
        $this->saveData['adms_sits_user_id'] = 1;
        $this->saveData['modified'] = date("Y-m-d H:i:s");

        $up_conf_email = new \App\adms\Models\helper\AdmsUpdate();
        $up_conf_email->exeUpdate("adms_users", $this->saveData, "WHERE id=:id", "id={$this->resultadoBd[0]['id']}");

        if ($up_conf_email->getResult()) {
            $_SESSION['msg'] = "E-mail ativado com sucesso!<br><br>";
            return $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Link inválido (não encontrado)!<br><br>";
            return $this->resultado = false;
        }
    }

}

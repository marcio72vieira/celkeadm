<?php

namespace App\adms\Models;

//use PDO;

class AdmsConfEmail extends helper\AdmsConn {

    private $resultadoBd;
    private $resultado;
    private string $chave;

    public function getResultado() {
        return $this->resultado;
    }

    public function confEmail($chave) {
        $this->chave = $chave;
        
        $viewChaveConfEmail =  new \App\adms\Models\helper\AdmsRead();
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
        //echo "Chave encontrada. ID: ". $this->resultadoBd[0]['id']. "<br>";
        //Atualizando os dados do banco sem utilizar um helpAdms
        //Definindo os valores a serem substituidos
        $conf_email = null;
        $adms_sits_user_id = 1;
        
        $query_ativar_user = "UPDATE adms_users SET conf_email =:conf_email, adms_sits_user_id =:adms_sits_user_id, modified = NOW()
         WHERE id =:id";
        $ativar_user = $this->connect()->prepare($query_ativar_user);
        $ativar_user->bindParam('conf_email', $conf_email);
        $ativar_user->bindParam('adms_sits_user_id', $adms_sits_user_id);
        $ativar_user->bindParam('id', $this->resultadoBd[0]['id']);
        $ativar_user->execute();
        
        //Testa se a execução ocorreu com sucesso. rowCount(), retorna a quantidade de registros afetada pela atualização,
        //logo rowCount() será um inteiro, isso implica que o resutado do if() abaixo será verdadeiro.
        if ($ativar_user->rowCount()) {
            $_SESSION['msg'] = "E-mail ativado com sucesso!<br><br>";
            return $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Link inválido (não encontrado)!<br><br>";
            return $this->resultado = false;
        }
    }

}

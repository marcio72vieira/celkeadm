<?php

namespace App\adms\Models;

//use PDO;

class AdmsNewConfEmail extends helper\AdmsConn {

    private array $dados;
    private $resultadoBd;
    private $resultado;

    public function getResultado() {
        return $this->resultado;
    }

    public function newConfEmail(array $dados = null) {
        $this->dados = $dados;
        
        $newConfEmail =  new \App\adms\Models\helper\AdmsRead();
        
        $newConfEmail->fullRead("SELECT id, name, email, conf_email FROM adms_users WHERE email =:email LIMIT :limit", "email={$this->dados['email']}&limit=1");
        
        $this->resultadoBd = $newConfEmail->getResult();
        
        //var_dump($viewUser->getResult());
        
        //Se não encontrou o email no banco de dados, informa que o email não está cadastrado
        if ($this->resultadoBd) {
            //Verifica se a coluna conf_email, através do método valConfEmail, possui algum valor ou se for null, 
            //para informar ou não um novo valor.
            if($this->valConfEmail()) {
                $_SESSION['msg'] = "Enviar E-mail, está tudo OK!<br><br>";
                return $this->resultado = false;
            } else {
                $_SESSION['msg'] = "Erro: Link não enviado tente novamente!<br><br>";
                return $this->resultado = false;
            }
        } else {
            $_SESSION['msg'] = "Erro: E-mail não cadastrado!<br><br>";
            return $this->resultado = false;
        }
    }
    
    private function valConfEmail() {
        if (empty($this->resultadoBd[0]['conf_email']) OR $this->resultadoBd[0]['conf_email'] == NULL ) {
            
            $conf_email = password_hash(date("Y-m-d H:i:s"), PASSWORD_DEFAULT);

            $query_ativar_user = "UPDATE adms_users SET conf_email =:conf_email, modified = NOW()
             WHERE id =:id";
            $ativar_user = $this->connect()->prepare($query_ativar_user);
            $ativar_user->bindParam('conf_email', $conf_email);
            $ativar_user->bindParam('id', $this->resultadoBd[0]['id']);
            $ativar_user->execute();

            if ($ativar_user->rowCount()) {
                $this->resultadoBd[0]['conf_email'] = $conf_email;
                return true;
            } else {
                return false;
            }
        } else {
            //Continua o processamento
            return true;
        }
    }

}

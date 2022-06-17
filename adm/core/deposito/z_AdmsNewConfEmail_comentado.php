<?php

namespace App\adms\Models;

//use PDO;


//Classe para configurar email
class AdmsNewConfEmail {

    private array $dados;
    private $resultadoBd;
    private $resultado;
    private array $saveData;

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
            
            //Criando uma nova "chave criptografada" para o conf_email e um valor para a coluna modified
            $this->saveData['conf_email'] = password_hash(date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
            $this->saveData['modified'] = date("Y-m-d H:i:s"); 
            
            //Instanciando a classe genéricaUpdate
            //Obs: bindParam é executado na classe genérica. bindParam, nada mais é apenas a atribuição
            //     dos linsks aos seus valores do tipo: conf_email = $conf_email, assim mesmo desta forma
            //     em um texto plano. Só que no bindParam, não é necessário colocar o sinal de igual, isso
            //     é feito pela função bindParam('link', 'valor'). Só para ficar claro.
            ////Leitura da linha abaixo: Eu quero editr na tabela adms-users os seguintes dados, $this->saveData, onde
             //a coluna id tenha o valor do link =:id. O valor do link =:id é esse valor: $this->resultadoBd[0]['conf_email']. 
            $up_conf_email = new \App\adms\Models\helper\AdmsUpdate();
            $up_conf_email->exeUpdate("adms_users", $this->saveData, "WHERE id=:id", "id={$this->resultadoBd[0]['id']}");
            
            if ($up_conf_email->getResult()) {
                $this->resultadoBd[0]['conf_email'] = $this->saveData['conf_email'];
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

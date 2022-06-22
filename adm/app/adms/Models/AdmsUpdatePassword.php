<?php

namespace App\adms\Models;

//use PDO;

class AdmsUpdatePassword {

    private $resultadoBd;
    private $resultado;
    private string $chave;
    private array $saveData;
    private array $dados;

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
            $this->resultado = true;
            return true;
        } else {
            $_SESSION['msg'] = "Erro: Link inválido, solicite novo link <a href='". URLADM ."recover-password/index'>Clique aqui</a>!<br><br>";
            $this->resultado = false;
            return false;
        }
    }
    
    public function editPassword(array $dados) {
        $this->dados = $dados;
        
        //Verificando se existe algum campo vaizo através do helpe ja criado anteriormente
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        
        if($valCampoVazio->getResultado()) {
            $this->valInput();
        } else {
            $this->resultado = false;
        }
        
    }
    
    private function valInput() {
        $valPassword = new \App\adms\Models\helper\AdmsValPassword();
        $valPassword->validarPassword($this->dados['password']);
        
        if($valPassword->getResultado()) {
            //echo "Continuar alteração da senha!<br>";
            //$this->resultado = false;
            
            if($this->validarChave($this->dados['chave'])) {
                $this->updatePassword();
            } else {
                $_SESSION['msg'] = "Erro: Link inválido, solicite novo link <a href='". URLADM ."recover-password/index'>Clique aqui</a>!<br><br>";
                return $this->resultado = false; 
            }
            
            
        } else {
            $this->resultado = false;
        }
    }
    
    private function updatePassword() {
        //Indicando quais campos no banco de dados serão atualizados
        $this->saveData['recover_password'] = null;     //Se o usuário já atualizou a senha não pode utilizar novamente a chave
        $this->saveData['password'] = password_hash($this->dados['password'], PASSWORD_DEFAULT);
        $this->saveData['modified'] = date("Y-m-d H:i:s");
        
        $upPassword = new \App\adms\Models\helper\AdmsUpdate();
        $upPassword->exeUpdate("adms_users", $this->saveData, "WHERE id =:id", "id={$this->resultadoBd[0]['id']}");
        
        if($upPassword->getResult()) {
            $_SESSION['msg'] = "Senha atualizada com sucesso!";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Senha não atualizada com sucesso. Tente novamente";
            $this->resultado = false;
        }
        
    }

}

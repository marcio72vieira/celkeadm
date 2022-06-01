<?php


namespace App\adms\Models\helper;

//Classe utilizada exclusivamente na parte de cadastro na página de Login
class AdmsValUserSingleLogin {
    
    private string $userName;
    private bool $resultado;
    private $resultadoBd;
    
    public function getResultado(): bool {
        return $this->resultado;
    }

   
    public function validarUserSingleLogin($username) {
        
        $this->userName = $username;
        
        //Instancia a classe genérica
        $valUserSingleLogin = new \App\adms\Models\helper\AdmsRead();
        
        $valUserSingleLogin->fullRead("SELECT id FROM adms_users WHERE username =:username LIMIT :limit", "username={$this->userName}&limit=1");
        
        $this->resultadoBd =  $valUserSingleLogin->getResult();
        
        
        //Se não encontrou nenhum usuário no banco de dados com o email fornecido, significa que PODE cadastrar, caso contrário NÃO PODE cadastrar, ou seja,
        //pode utilizar o email
        if(!$this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Este e-mail já está cadastrado!";
            $this->resultado = false;
        }
        
        
        
        /*
        //Validando o email, com uma função própria do php
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->resultado = true;  
        } else {
            $_SESSION['msg'] = "Erro: E-mail inválido!";
            $this->resultado = false;
        }
        */
    }
}

<?php


namespace App\adms\Models\helper;

//Classe utilizada exclusivamente na parte de cadastro de novo usuario
class AdmsValUserSingle {
    
    private string $userName;
    private $edit;
    private $id;
    private bool $resultado;
    private $resultadoBd;
    
    public function getResultado(): bool {
        return $this->resultado;
    }

   
    public function validarUserSingle($username, $edit = null, $id = null) {
        
        $this->userName = $username;
        $this->edit = $edit;
        $this->id = $id;
        
        //Instancia a classe genérica
        $valUserSingle = new \App\adms\Models\helper\AdmsRead();
        
        if(($this->edit == true) AND (!empty($this->id))) {
            $valUserSingle->fullRead("SELECT id FROM adms_users WHERE (username =:username OR email =:email) AND id<>:id LIMIT :limit", "username={$this->userName}&email={$this->userName}&id={$this->id}&limit=1");
        } else {
           $valUserSingle->fullRead("SELECT id FROM adms_users WHERE username =:username LIMIT :limit", "username={$this->userName}&limit=1"); 
        }
        
        $this->resultadoBd =  $valUserSingle->getResult();
        
        
        //Se não encontrou nenhum usuário no banco de dados com o email fornecido, significa que PODE cadastrar, caso contrário NÃO PODE cadastrar, ou seja,
        //pode utilizar o email
        if(!$this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Este usuário já está cadastrado!";
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

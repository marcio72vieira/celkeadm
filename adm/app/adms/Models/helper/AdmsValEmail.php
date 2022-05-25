<?php


namespace App\adms\Models\helper;


class AdmsValEmail {
    
    private string $email;
    private bool $resultado;
    
    public function getResultado(): bool {
        return $this->resultado;
    }

    public function validarEmail($email) {
        
        $this->email = $email;
        
        //Validando o email, com uma função própria do php
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->resultado = true;  
        } else {
            $_SESSION['msg'] = "Erro: E-mail inválido!";
            $this->resultado = false;
        }
         
    }
}

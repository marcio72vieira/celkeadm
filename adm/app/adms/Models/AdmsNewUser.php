<?php

namespace App\adms\Models;

//use PDO;

class AdmsNewUser extends helper\AdmsConn {

    private array $dados;
    private bool $resultado;
    private string $fromEmail;

    public function getResultado() {
        return $this->resultado;
    }

    public function create(array $dados = null) {
        //Recebe os dados do formulário enviado pelo objeto $createNewUser, no método index() do controller NewUser.php
        $this->dados = $dados;

        //Instancia e invoca a validação de campos
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);

        //Testa a validação de campos após receber todos os campos
        if ($valCampoVazio->getResultado()) {
            $this->valInput();
        } else {
            $this->resultado = false;
        }
    }
    
    //Valida a entrada do email, se válido e único no bd
    private function valInput() {
        //Valida o email se está no formato correto
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validarEmail($this->dados['email']);
        
        //Valida o email se é único no banco de dados
        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validarEmailSingle($this->dados['email']);
        
        //Valida a senha
        $valPassword = new \App\adms\Models\helper\AdmsValPassword();
        $valPassword->validarPassword($this->dados['password']);
        
        //Valida o username se é único no banco de dados
        $valUserSingleLogin = new \App\adms\Models\helper\AdmsValUserSingleLogin();
        $valUserSingleLogin->validarUserSingleLogin($this->dados['email']);
        
        if($valEmail->getResultado() AND $valEmailSingle->getResultado()  AND $valPassword->getResultado() AND $valUserSingleLogin->getResultado()) {
            //$_SESSION['msg'] = 'Usuário deve ser cadastrado!';
            //$this->resultado = false;
            $this->add();
        } else {
            $this->resultado = false;
        }
    }

    private function add() {
        //Criptografando a senha
        $this->dados['password'] = password_hash($this->dados['password'], PASSWORD_DEFAULT);
        $this->dados['username'] = $this->dados['email'];
        $this->dados['created'] = date("Y-m-d H:i:s");

        //Instanciando um objeto do tipo AdmCreate e invocando os seus métodos
        $createUser = new \App\adms\Models\helper\AdmsCreate();
        $createUser->exeCreate("adms_users", $this->dados);

        if ($createUser->getResult()) {
            //Invoca o método sendEmail desta classe
            $this->sendEmail();
        } else {
            $_SESSION['msg'] = "Erro: Usuário não cadastrado!<br>";
            $this->resultado = false;
        }
    }
    
    private function sendEmail() {
        
        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();   //Cria um objeto do tipo AdmsSendEmail
        $sendEmail->sendEmail(1);                                   //Invoca o método sendEmail do objeto criado, 
                                                                    //indicando o tipo de email a ser enviado 
                                                                    //(1-atendiemnto; 2 - suporte, 3 - não responda)
        
        if($sendEmail->getResultado()) {
            $_SESSION['msg'] = "Usuário cadastrado com sucesso!<br>Acesse sua caixa de e-mail para confirmar o e-mail";
            $this->resultado = false;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "Usuário cadastrado com sucesso!<br>Houve erro ao enviar e-mail de confirmação. Entre em contato com ". $this->fromEmail ."para mais informações";
            $this->resultado = false;
        }
    }

}

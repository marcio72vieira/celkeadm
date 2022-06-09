<?php

namespace App\adms\Models;

//use PDO;

class AdmsNewUser 
{

    private array $dados;
    private bool $resultado;
    private string $fromEmail;
    private string $firstName;
    private array $emailData;

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
        //Criptografando a senha, atribuindo ao usernameo mesmo valor do email e criptografando o link para confirmar email(senha + data atual)
        $this->dados['password'] = password_hash($this->dados['password'], PASSWORD_DEFAULT);
        $this->dados['username'] = $this->dados['email'];
        $this->dados['conf_email'] = password_hash($this->dados['password'].date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
        $this->dados['created'] = date("Y-m-d H:i:s");

        //Instanciando um objeto do tipo AdmCreate e invocando os seus métodos
        $createUser = new \App\adms\Models\helper\AdmsCreate();
        $createUser->exeCreate("adms_users", $this->dados);

        if ($createUser->getResult()) {
            //Invoca o método sendEmail desta classe
            $this->sendEmail();
        } else {
            $_SESSION['msg'] = "Erro: Usuário não cadastrado. Tente mais tarde!<br>";
            $this->resultado = false;
        }
    }
    
    private function sendEmail() {
        
        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();   //Cria um objeto do tipo AdmsSendEmail
        
        //Invocando os conteúdos html e text para depois instanciar o método sendEmail()
        $this->emailHtml();
        $this->emailText();
        
        //Enviando os dados do email (formatação html e text) juntamente com o email desejado (Atendimento, suporte, noreplay etc...)
        $sendEmail->sendEmail($this->emailData, 1);                 //Invoca o método sendEmail do objeto criado, 
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
    
    //Método responsável por montar um e-mail HTML
    private function emailHtml() {
        //Resgatando a primeira parte do nome que o usuário digitar
        $name = explode(" ", $this->dados['name']);
        $this->firstName = $name[0];
        
        $this->emailData['toEmail'] = $this->dados['email'];
        $this->emailData['toName'] = $this->firstName;
        $this->emailData['subject'] = "Confirmar sua conta";
        
        //Criando a variável(url) para confirmação de email enviada no corpo do email
        //Esta variável é composta pela constante URLADM + controle/método conf-email/index + chave que recebe a criptografia gerada acima
        $urlConfEmail = URLADM . "conf-email/index?chave=" . $this->dados['conf_email'];
        
        $this->emailData['contentHtml']  = "Prezado(a) {$this->firstName} <br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastramento em nosso site<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do email, clicando no link abaixo<br><br>";
        $this->emailData['contentHtml'] .= "<a href='". $urlConfEmail ."'>". $urlConfEmail ."></a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>";
        $this->emailData['contentHtml'] .= "Você está recebendo porquê está cadastrado no bando de dados da empresa XXX. ";
        $this->emailData['contentHtml'] .= "Nenhum e-mail enviado pela empresa XXX tem arquivos anexos ou solicita o preenchimento de senhas ";
        $this->emailData['contentHtml'] .= "ou informações cadastrais<br><br>";
    }
    
    //Método responsável por montar um e-mail TEXT
    private function emailText() {
        //Os dados toEmail, toName e subject, ja foram definidos no método acima em emailHtml()
        
        //Criando a variável(url) para confirmação de email enviada no corpo do email. Houve a necessidade de se criar
        //aqui novamente, porque se trata de uma variável e não de uma propriedade. Sendo uma variável, ele só existe
        //no scopo do método onde ela foi criada.
        //Esta variável é composta pela constante URLADM + controle/método conf-email/index + chave que recebe a criptografia gerada acima
        $urlConfEmail = URLADM . "conf-email/index?chave=" . $this->dados['conf_email'];
        
        $this->emailData['contentText']  = "Prezado(a) {$this->firstName} \n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastramento em nosso site\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do email, clicando no link abaixo ou cole o link no navegador\n\n";
        $this->emailData['contentText'] .= $urlConfEmail."\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa XXX.\n";
        $this->emailData['contentText'] .= "Você está recevendo porquê está cadastrado no bando de dados da empresa XXX.";
        $this->emailData['contentText'] .= "Nenhum e-mail enviado pela empresa XXX tem arquivos anexos ou solicita o preenchimento de senhas ";
        $this->emailData['contentText'] .= "ou informações cadastrais\n\n";
    }

}

<?php

namespace App\adms\Models;

//use PDO;

class AdmsNewConfEmail extends helper\AdmsConn {

    private array $dados;
    private $resultadoBd;
    private $resultado;
    private string $firstName;
    private array $emailData;

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
                $this->sendEmail();
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
    
    
    private function sendEmail() {
        
        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();   //Cria um objeto do tipo AdmsSendEmail
        
        //Invocando os conteúdos html e text para depois instanciar o método sendEmail()
        $this->emailHtml();
        $this->emailText();
        
        //Enviando os dados do email (formatação html e text) juntamente com o email desejado (Atendimento, suporte, noreplay etc...)
        $sendEmail->sendEmail($this->emailData, 2);                 //Invoca o método sendEmail do objeto criado, 
                                                                    //indicando o tipo de email a ser enviado 
                                                                    //(1-atendiemnto; 2 - suporte, 3 - não responda)
        
        if($sendEmail->getResultado()) {
            $_SESSION['msg'] = "Novo link enviado com sucesso!<br>Acesse sua caixa de e-mail para confirmar o e-mail";
            $this->resultado = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "Erro: Link não enviado, tente novamente ou entre em contato com ". $this->fromEmail ." para mais informações";
            $this->resultado = false;
        }
    }
    
    //Método responsável por montar um e-mail HTML
    private function emailHtml() {
        //Resgatando a primeira parte do nome que o usuário digitar
        $name = explode(" ", $this->resultadoBd[0]['name']);
        $this->firstName = $name[0];
        
        $this->emailData['toEmail'] = $this->resultadoBd[0]['email'];
        $this->emailData['toName'] = $this->firstName;
        $this->emailData['subject'] = "Confirmar sua conta";
        
        //Criando a variável(url) para confirmação de email enviada no corpo do email
        //Esta variável é composta pela constante URLADM + controle/método conf-email/index + chave que recebe a criptografia gerada acima
        $urlConfEmail = URLADM . "conf-email/index?chave=" . $this->resultadoBd[0]['conf_email'];
        
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
        $urlConfEmail = URLADM . "conf-email/index?chave=" . $this->resultadoBd[0]['conf_email'];
        
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

<?php

namespace App\adms\Models\helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AdmsSendEmail {

    private array $dados;
    private array $dadosInfoEmail;
    private array $resultadoBd;
    private bool $resultado;
    private string $fromEmail;
    private int $optionConfEmail;

    public function getResultado(): bool {
        return $this->resultado;
    }
    
    public function getFromEmail(): string {
        return $this->fromEmail;
    }

    
    public function sendEmail($dados, $optionConfEmail) {
        $this->optionConfEmail = $optionConfEmail;
        
        $this->dados = $dados;      //A propriedade dados, recebe os dados para quem sera enviado o email
        
        
        /*
        //Definindo quem recebe o email e o conteúdo
        $this->dados['toEmail'] = 'ester@email.com';
        $this->dados['toName'] = 'Ester Clévia';
        $this->dados['subject'] = 'Confirmar Email';
        $this->dados['contentHtml'] = "Olá <b>Ester Clevia dos Santos</b><br><p>Cadastro realizado com sucesso!</p>";
        //Obs: Para ter uma correta interpretação dos caracteres de scape \n\t etc.. é necessário a mensagem estar envolta por aspas duplas
        $this->dados['contentText'] = "Olá Ester Clevia dos Santos \n\n Cadastro realizado com sucesso!\n";
        */
        
        $this->infoPhpMailer();
        
        //Invocando o método para enviar email pelo PhpMailer
        $this->sendEmailPhpMailer();
    }
    
    
    //Definindo as credenciais para envio do email, a partir do banco de dados
    private function infoPhpMailer() {
        //Instanciando a classe GENÉRICA de buscar informações no banco de dados
        $confEmail = new \App\adms\Models\helper\AdmsRead();
        $confEmail->fullRead("SELECT name, email, host, username, password, smtpsecure, port FROM adms_confs_emails WHERE id =:id LIMIT :limit", "id={$this->optionConfEmail}&limit=1");
        $this->resultadoBd = $confEmail->getResult();
        
        //echo "<pre>"; var_dump($this->resultadoBd); echo "</pre>";
        
        
       
        $this->dadosInfoEmail['host']       = $this->resultadoBd[0]['host'];
        $this->dadosInfoEmail['fromEmail']  = $this->resultadoBd[0]['email'];
        //Definindo o email para quem o destinatário deverá informar à respeito de um erro no envio do email
        $this->fromEmail = $this->dadosInfoEmail['fromEmail'];
        $this->dadosInfoEmail['fromName']   = $this->resultadoBd[0]['name'];
        $this->dadosInfoEmail['username']   = $this->resultadoBd[0]['username'];
        $this->dadosInfoEmail['password']   = $this->resultadoBd[0]['password'];
        $this->dadosInfoEmail['smtpsecure'] = $this->resultadoBd[0]['smtpsecure'];
        $this->dadosInfoEmail['port']       = $this->resultadoBd[0]['port'];
    }

    private function sendEmailPhpMailer() {
        
        $mail = new PHPMailer(true);

        try {
            //Configurações do servidor
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                //Enable verbose debug output
            $mail->CharSet = 'UTF-8';                               //Set character map Português (áçéã etc...)
            $mail->isSMTP();                                        //Send using SMTP
            $mail->Host = $this->dadosInfoEmail['host'];            //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                 //Enable SMTP authentication
            $mail->Username = $this->dadosInfoEmail['username'];    //SMTP username
            $mail->Password = $this->dadosInfoEmail['password'];    //SMTP password
            $mail->SMTPSecure = $this->dadosInfoEmail['smtpsecure'];     //Enable implicit TLS encryption
            $mail->Port = $this->dadosInfoEmail['port'];                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS` 
            
            //Email e nome de quem está enviando
            $mail->setFrom($this->dadosInfoEmail['fromEmail'], $this->dadosInfoEmail['fromName']);
            
            //Email e nome de quem estará recebendo
            $mail->addAddress($this->dados['toEmail'], $this->dados['toName']);     //Add a recipient
            
            
            /*
            $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');
            //Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            */
            
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $this->dados['subject'];
            $mail->Body = $this->dados['contentHtml'];
            $mail->AltBody = $this->dados['contentText'];

            $mail->send();
            $this->resultado = true;
        } catch (Exception $e) {
            $this->resultado = false;
        }
    }

}

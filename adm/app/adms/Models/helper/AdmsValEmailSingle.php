<?php


namespace App\adms\Models\helper;


class AdmsValEmailSingle {
    
    private string $email;
    private $edit;
    private $id;
    private bool $resultado;
    private $resultadoBd;
    
    public function getResultado(): bool {
        return $this->resultado;
    }

    //O parâmetro $edit, é para saber se o usuário esta editando ou não, caso esteja editando, irá permitir com que o email permaneça o mesmo com
    //base no $id recebido.
    public function validarEmailSingle($email, $edit = null, $id = null) {
        
        $this->email = $email;
        $this->edit = $edit;
        $this->id = $id;
        
        
        //Para verificar se o usuário já está cadastrado (o email ja está cadastrado), é necessário pesquisar no banco de dados. Para isso faz-se 
        //uso da classe genérica AdmsRead
        $valEmailSingle = new \App\adms\Models\helper\AdmsRead();
        
        
        //Se estou querendo editar verifico se o email existe no banco de dados inteiro, com exceção do usuário, cujo id foi fornecido, ou sej, eu ignoro o 
        //usuário pelo seu id. //Se estou querendo cadastrar, veriico se o email existe no banco de dados inteiro para ver se o email já está cadastrado
        //Se $edit for igual a verdadeiro e o $id não estiver vazio, significa que estou querendo editar, caso contrário estou querendo cadastrar
        if(($this->edit == true) AND (!empty($this->id))) {
            //Quando utilizado para cadastro a instrução abaixo testa apenas o email para ver se já não existe
            //$valEmailSingle->fullRead("SELECT id FROM adms_users WHERE email =:email AND id <>:id LIMIT :limit", "email={$this->email}&id={$this->id}&limit=1");
            //Quando utilizado para edição foi necessário acrescentar mais uma condiçãona cláusula WHERE
            $valEmailSingle->fullRead("SELECT id FROM adms_users WHERE (email =:email OR username =:username) AND id <>:id LIMIT :limit", "email={$this->email}&username={$this->email}&id={$this->id}&limit=1");
            
        } else {
            $valEmailSingle->fullRead("SELECT id FROM adms_users WHERE email =:email LIMIT :limit", "email={$this->email}&limit=1");
        }
        
        $this->resultadoBd =  $valEmailSingle->getResult();
        
        
        //Se não encontrou nenhum usuário no banco de dados com o email fornecido, significa que PODE cadastrar, caso contrário NÃO PODE cadastrar, ou seja,
        //pode utilizar o email
        if(!$this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: E-mail já está cadastrado!";
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

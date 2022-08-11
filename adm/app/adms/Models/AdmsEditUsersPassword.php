<?php

namespace App\adms\Models;

/**
 * Description of AdmsViewUsers
 *
 * @author marcio
 */
class AdmsEditUsersPassword {

    private $resultadoBd;
    private bool $resultado;
    private int $id;
    private array $dados;
    

    public function getResultado(): bool {
        return $this->resultado;
    }

    public function getResultadoBd() {
        return $this->resultadoBd;
    }

    //O nome desse método poderia ser recoverUser, ou recoverRecord etc..
    public function viewUser($id) {
        $this->id = (int) $id;
        //echo "ID na models {$this->id}<br>";
        //Buscando no banco de dados as informações referente ao usuário passado no ID
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id FROM adms_users WHERE id =:id LIMIT :limit", "id={$this->id}&limit=1");

        //O resultado retornado pela métdo getResult (ou seja, o resultado do banco de dados), de AdmsRead() é atribuido á propriedade getResultadoBd desta classe
        $this->resultadoBd = $viewUser->getResult();

        //Verifica se encontrou algum registro no banco de dados
        if ($this->resultadoBd) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Usuário não encontrado!<br>";
            $this->resultado = false;     //Retorna a lista de usuários
            //$this->resultado = true;        //Mesmo não encontrando usuário nenhum, acessa a view e mostra que o usuário não foi encontrado
        }
    }
    
    //O nome deste método poderia ser updateUser, ou updateRecord etc...
    public function update(array $dados) {
        $this->dados =  $dados;
       
        //Verifica se o campo senha está preenchido
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if($valCampoVazio->getResultado()) {
            $this->valInput();
        } else {
            $this->resultado = false;
        }
    }
    
    private function valInput () {
        //Faz a verificação se o email é valido
        $valPassword = new \App\adms\Models\helper\AdmsValPassword;
        $valPassword->validarPassword($this->dados['password']);
        
        //Verifica se a validaçãopassou no teste, verifidando o valor de getResultado
        if($valPassword->getResultado()) {
            $this->edit();
        } else {
            $this->resultado = false;
        }
    } 
    
    private function edit() {
        $this->dados['password'] = password_hash($this->dados['password'], PASSWORD_DEFAULT);
        //$this->dados['username'] = $this->dadosExitVal['username']; //Adicionando outros campos para não obrigar a validação
        $this->dados['modified'] = date("Y-m-d H:i:s");
        //var_dump($this->dados);
        
        $upUser =  new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");
        
        if($upUser->getResult()) {
            $_SESSION['msg'] = "Senha do usuário editado com sucesso!<br>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Senha do usuário não editado com sucesso!<br>";
            $this->resultado = false;
        }
    }

}

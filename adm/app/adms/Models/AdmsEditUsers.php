<?php

namespace App\adms\Models;

/**
 * Description of AdmsViewUsers
 *
 * @author marcio
 */
class AdmsEditUsers {

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
        $viewUser->fullRead("SELECT id, name, nickname, email, username FROM adms_users WHERE id =:id LIMIT :limit", "id={$this->id}&limit=1");

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
        //echo "<pre>"; var_dump($this->dados); echo "</pre>";
        
        //Verifica se algum campo está vazio
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
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validarEmail($this->dados['email']);
        
        //Faz a verificação se o email é único no campo email e username do banco de dados
        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validarEmailSingle($this->dados['email'], true, $this->dados['id']);
        
        //Faz a verificação se o usuário é único
        $valUserSingle =  new \App\adms\Models\helper\AdmsValUserSingle();
        $valUserSingle->validarUserSingle($this->dados['username'], true, $this->dados['id']);
        
        //Verifica se as validações passaram no teste, verifidando o valor de getResultado
        if($valEmail->getResultado() AND $valEmailSingle->getResultado() AND $valUserSingle->getResultado()) {
            //$_SESSION['msg'] = "Editar Usuário!<br>";
            //$this->resultado = false;
            $this->edit();
        } else {
            $this->resultado = false;
        }
    } 
    
    private function edit() {
        $this->dados['modified'] = date("Y-m-d H:i:s");
        //var_dump($this->dados);
        
        $upUser =  new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->dados, "WHERE id =:id", "id={$this->dados['id']}");
        
        if($upUser->getResult()) {
            $_SESSION['msg'] = "Usuário editado com sucesso!<br>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: Usuário não editado com sucesso!<br>";
            $this->resultado = false;
        }
    }

}

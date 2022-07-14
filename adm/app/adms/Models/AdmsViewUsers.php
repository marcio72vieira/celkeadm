<?php

namespace App\adms\Models;

/**
 * Description of AdmsViewUsers
 *
 * @author marcio
 */
class AdmsViewUsers {

    private $resultadoBd;
    private bool $resultado;
    private int $id;

    public function getResultado(): bool {
        return $this->resultado;
    }

    public function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function viewUser($id) {
        $this->id = (int) $id;
        //echo "ID na models {$this->id}<br>";
        //Buscando no banco de dados as informações referente ao usuário passado no ID
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, name, email FROM adms_users WHERE id =:id LIMIT :limit", "id={$this->id}&limit=1");

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

}

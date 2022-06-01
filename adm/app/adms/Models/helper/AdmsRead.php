<?php

namespace App\adms\Models\helper;

use PDO;
use Exception;


class AdmsRead extends AdmsConn {

    private string $select;
    private array $values = [];
    private array $result = [];
    private object $query;
    private object $conn;

    public function getResult(): array {
        return $this->result;
    }

    public function exeRead($tabela, $termos = null, $paseString = null) {

        if (!empty($paseString)) {
            //Obs: não deve haver espaços em branco dentro do parâmetro da parsestring vindo como parâmetro
            //Converte o valor de $parseString em um array e atribui à propriedade $this->values (que é um array).
            parse_str($paseString, $this->values);
        }
        
        $this->select = "SELECT * FROM {$tabela} {$termos}";
        
        $this->exeInstruction();
    }
    
    public function fullRead($query, $paseString = null) {
        //Recebe o primeiro parâmetro (select campos form tabela where etc...)
        $this->select = $query;
        
        //Recebe o segundo parâmetro (email :=email, user :=user, limit = limit etc...) se for informado e deposita no array $this->values
        if (!empty($paseString)) {
            //Obs: não deve haver espaços em branco dentro do parâmetro da parsestring vindo como parâmetro
            //Converte o valor de $parseString em um array e atribui à propriedade $this->values (que é um array).
            parse_str($paseString, $this->values);
            
            $this->exeInstruction();
        }
        
    }
    
    private function exeInstruction() {
        $this->connection();
        try {
            $this->exeParameter();
            $this->query->execute();
            $this->result  = $this->query->fetchAll();
        } catch (Exception $ex) {
            $this->result = null;
        }
    }
    
    private function connection() {
        //Abre a conexão com o banco
        $this->conn = $this->connect();
        //Prepara a consulta que está contida na propriedade select
        $this->query = $this->conn->prepare($this->select);
        //Recebe os valores através do FETCH_ASSOC
        $this->query->setFetchMode(PDO::FETCH_ASSOC);
    }
    
    private function exeParameter() {
        //Verifica se $this->values é verdadeiro, ou seja, se foi enviado parâmetros. Exite valor
        if($this->values) {
            foreach ($this->values as $link => $value) {
                //Verifica se o 'link: user, limit, offset etc..' é um inteiro
                if($link == 'limit' || $link == 'offset') {
                    //força o valor ser um inteiro se link for limt ou offeset
                    $value = (int) $value;
                }
                //Substituindo o link pelo valor. Se for inteiro, atribua int, caso contrário atribua string
                $this->query->bindValue(":{$link}", $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
        }
    }

}

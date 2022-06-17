<?php

namespace App\adms\Models\helper;

//use PDO;
use Exception;

class AdmsUpdate extends AdmsConn {

    private string $table;
    private string $termos;
    private array $data;
    private array $values = [];
    private string $result;
    private object $update;
    private $query;
    private object $conn;
    
    public function getResult(): string {
        return $this->result;
    }

    // Recebe o nome da tabela, os dados (data) a serem atualizados os termos, condição e a parsestring que irá
    // ser utilizada para realizar o bindParam, que na verdade é epenas a atribuição de valores pelos links
    public function exeUpdate($table, array $data, $termos = null, $parseString = null): void {
        $this->table = (string) $table;
        $this->data = $data;
        echo "<pre>"; var_dump($this->data); echo "</pre>";
        $this->termos = (string) $termos;

        // Transformando a string ($parseString) em um array ($this->values) através da função parse_str do php
        parse_str($parseString, $this->values);
        echo "<pre>"; var_dump($parseString); echo "</pre>";
        echo "<pre>"; var_dump($this->values); echo "</pre>";
        
        //Instanciando o método para convertendo o array ($this->data) para  modelo nome_da_coluna1 =:link1 
        $this->exeReplaceValues();
        //Executando a instrução
        $this->exeInstruction();
        
    }
    
    //Convertendo o array ($this->data) para  modelo nomecoluna1 =:linkco1una1, nomecoluna2 =:linkco1una2, etc...
    public function exeReplaceValues() {
        foreach ($this->data as $key => $value) {
            $values[] = $key ."=:". $key;             //Ex: conf_email=:conf_email  (nome da coluna =: link)
        }
        echo "<pre>"; var_dump($values); echo "</pre>";
        //Agora transformamos o array $values, para uma string única: coluna1=:coluna1, coluna12=: etc...
        $values = implode(", ", $values);
        echo "<br>$values";
        
        //Criando a estrutura básica da query,no estilo: 
        //"UPDATE adms_users SET conf_email =:conf_email, modified = NOW() WHERE id =:id"
        $this->query = "UPDATE {$this->table} SET {$values} $this->termos";
        echo "<pre>"; var_dump($this->query); echo "</pre>";
    }
    
    //Executando a instrução preparada pelo método exeReplaceValues
    private function exeInstruction() {
        //Invocando o método de conexão e preparando a query
        $this->connection();
        
        //executando a query update($this->update), substituindo os links pelos seus respectivos valores através do array_merge
        //A substituição do link pelo valor é onde é efetivado o bindParam
        try {
            $this->update->execute(array_merge($this->data, $this->values));
            $this->result = true;
        } catch (Exception $ex) {
            $this->result = null;
        }
    }
    
    private function connection() {
        $this->conn = $this->connect();
        $this->update = $this->conn->prepare($this->query);
        
    }

}

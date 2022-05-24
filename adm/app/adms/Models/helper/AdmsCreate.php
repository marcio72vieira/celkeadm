<?php

namespace App\adms\Models\helper;

//use PDO;
use Exception;

class AdmsCreate extends AdmsConn {

    private string $table;
    private array $data;
    private string $result;
    private object $insert;
    private string $query;
    private object $conn;
    
    public function getResult(): string {
        return $this->result;
    }

    public function exeCreate($table, array $data): void {
        $this->table = (string) $table;
        $this->data = $data;
        $this->exeReplaceValues();
        $this->exeInstruction();
    }
    
    private function exeReplaceValues(): void {
        //Obtendo os campos, nome dos campos
        $columns = implode(', ', array_keys($this->data));
        //Obtendo os links, links correspondente aos campos
        $values = ':'.implode(', :', array_keys($this->data));
        //Construindo a query
        $this->query = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
    }
    
    private function exeInstruction(): void {
        $this->connection();
        try {
            //O insert, já possui a query preparada no método connection()
            $this->insert->execute($this->data);
            //Obtendo o último id inserido nno banco
            $this->result = $this->conn->lastInsertId();
        } catch (Exception $ex) {
            $this->result = null;
            
        }
        
    }
    
    private function connection () {
        $this->conn = $this->connect();
        //Preparando a query
        $this->insert = $this->conn->prepare($this->query);
    }

}

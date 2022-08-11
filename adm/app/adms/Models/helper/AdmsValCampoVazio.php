<?php


namespace App\adms\Models\helper;


class AdmsValCampoVazio {
    
    private array $dados;
    private bool $resultado;
    
    public function getResultado(): bool {
        return $this->resultado;
    }

        
    
    
    public function validarDados(array $dados) {
        
        $this->dados = $dados;
        $this->dados = array_map('strip_tags', $this->dados);       //retira as tag's html do valor dos campos
        $this->dados = array_map('trim', $this->dados);             //retira os espaços em branco dos campos
        
        //Verifica se no array de dados, possui algum campo vazio, ou seja, se algum elemento do array é igual
        //a espaço em branco ''
        if (in_array('', $this->dados)) {
            $_SESSION['msg'] = "Erro: Necessário preencher todos os campos!";
            $this->resultado = false;
        } else {
            $this->resultado = true;
        }
         
    }
}

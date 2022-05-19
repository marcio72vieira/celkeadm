<?php

namespace Core;

class CarregarPgAdm {

    private string $urlController;
    private string $urlMetodo;
    private string $urlParametro;
    private string $class;

    public function carregarPg($urlController = null, $urlMetodo = null, $urlParametro = null) {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParametro = $urlParametro;

        $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
        if (class_exists($this->classe)) {
            $this->carregarMetodo();
        } else {
            //Se a página não existir, redireciona par a página de login (CONTROLLER)
            $this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParametro = "";
            $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
            $this->carregarMetodo();
        }
    }

    private function carregarMetodo() {
        $classeCarregar = new $this->classe();
        
        if (method_exists($classeCarregar, $this->urlMetodo)) {
            $classeCarregar->{$this->urlMetodo}();
        } else {
            die('Erro (Método): Por favor tente novamente. Caso o erro persista entre em contato com o administrador: '. EMAILADM .'<br>');
        }
        
        
    }

    private function slugController($slugController) {
        //Converter para minúsculo
        $this->slugController = strtolower($slugController);
        //Substituir o traço para espaço em branco
        $this->slugController = str_replace("-", " ", $this->slugController);
        //Colocar a primeira letra de cada palavra do controller em maiúscula
        $this->slugController = ucwords($this->slugController);
        //Retirar os espaços em branco
        $this->slugController = str_replace(" ", "", $this->slugController);
        return $this->slugController;
    }

    private function slugMetodo($slugMetodo) {
        //Converter para minúsculo  
        $this->slugMetodo = strtolower($slugMetodo);
        //Substituir o traço para espaço em branco 
        $this->slugMetodo = str_replace("-", " ", $this->slugMetodo);
        //Converter a primeira letra de cada palavra do controller em maiúscula
        $this->slugMetodo = ucwords($this->slugMetodo);
        //Retirar os espaços em branco
        $this->slugMetodo = str_replace(" ", "", $this->slugMetodo);
        //Converter a primeira letra para minúscula
        $this->slugMetodo = lcfirst($this->slugMetodo);
        return $this->slugMetodo;
    }

}

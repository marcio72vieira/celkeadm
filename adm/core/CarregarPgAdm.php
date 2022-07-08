<?php

namespace Core;

class CarregarPgAdm {

    private string $urlController;
    private string $urlMetodo;
    private string $urlParametro;
    private string $classe;
    private array $pgPublica;
    private array $pgRestrita;

    public function carregarPg($urlController = null, $urlMetodo = null, $urlParametro = null) {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParametro = $urlParametro;

        $this->pgPublica();

        if (class_exists($this->classe)) {
            $this->carregarMetodo();
        } else {
            //Se a página(classe) não existir, define o Controller, Metodo e Parâmetro padrão, ou seja página de Login
            $this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParametro = "";
            $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
            $this->carregarMetodo();
        }
    }

    private function carregarMetodo() {
        // Instancia um objeto. É necessário neste ponto, acrescentar o (), pois $this->classe só possui até então,
        // o caminho: "\\App\\adms\\Controllers\\".nome_da_classe
        $classeCarregar = new $this->classe();
        // Se a classe existir e o método não, o programa é abortado, caso contrário, o método é invocado. Observe que como
        // a classe, é necessário acrescentar (), pois também só temos o nome do método
        if (method_exists($classeCarregar, $this->urlMetodo)) {
            $classeCarregar->{$this->urlMetodo}();
        } else {
            die('Erro (Método): Por favor tente novamente. Caso o erro persista entre em contato com o administrador: ' . EMAILADM . '<br>');
        }
    }
    
    private function pgPublica() {
        $this->pgPublica = ["Login", "Sair", "NewUser", "ConfEmail", "NewConfEmail", "RecoverPassword", "UpdatePassword"];
        
        if (in_array($this->urlController, $this->pgPublica)) {
            $this->classe = "\\App\\adms\\Controllers\\". $this->urlController;
        } else {
            $this->pgRestrita();
        }
    }
    
    private function pgRestrita() {
        $this->pgRestrita = ["Dashboard", "ListUsers"];
        
        if (in_array($this->urlController, $this->pgRestrita)) {
            
            $this->verificarLogin();
            
        } else {
            $_SESSION['msg'] = "Erro: Página não encontrada!<br>";
            $urlDestino = URLADM. "login/index";
            header("Location: $urlDestino");
        }
    }
    
    public function verificarLogin() {
        
        if (isset($_SESSION['user_id']) AND isset($_SESSION['user_name']) AND isset($_SESSION['user_email'])) {
            $this->classe = "\\App\\adms\\Controllers\\". $this->urlController;
        } else {
            $_SESSION['msg'] = "Erro: Para acessar a página realize o login!<br>";
            $urlDestino = URLADM. "login/index";
            header("Location: $urlDestino");
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

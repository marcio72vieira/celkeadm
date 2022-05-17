<?php

namespace Core;

class ConfigController extends Config {

    private string $url;
    private array $urlConjunto;
    private string $urlController;
    private string $urlMetodo;
    private string $urlParametro;
    private string $classe;

    public function __construct() {
        
        //Acessando o método da classe Config, para utilizar as constantes
        $this->configAdm();

        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            
            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            
            $this->urlConjunto = explode("/", $this->url);
            
            var_dump($this->urlConjunto);

            // Verifica se há um controller
            if (isset($this->urlConjunto[0])) {
                $this->urlController = $this->urlConjunto[0];
            } else {
                $this->urlController = CONTROLLER;
            }
            
            // Verifica se há um método
            if (isset($this->urlConjunto[1])) {
                $this->urlMetodo = $this->urlConjunto[1];
            } else {
                $this->urlMetodo = METODO;
            }
            
            // Verifica se há um parâmetro
            if (isset($this->urlConjunto[2])) {
                $this->urlParametro = $this->urlConjunto[2];
            } else {
                $this->urlParametro = "";
            }
        } else {
            echo "Criar a página default!<br>";
            $this->urlController = CONTROLLER;
            $this->urlMetodo = METODO;
            $this->urlParametro = "";
        }
        
        echo "<br>";
        echo "Controller: {$this->urlController}<br>";
        echo "Método: {$this->urlMetodo}<br>";
        echo "Parâmetro: {$this->urlParametro}<br>";
    }
    
    
    public function carregar() {
        echo "Carregar as Páginas!<br>";
        $this->urlController = ucwords($this->urlController);
        echo "Controller corrigida: ". $this->urlController;
        $this->classe = "\\App\\adms\\Controllers\\". $this->urlController;
        $classeCarregar = new $this->classe();
        $classeCarregar->{$this->urlMetodo}();
    }

}

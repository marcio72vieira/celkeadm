<?php

namespace Core;

class ConfigController extends Config {

    private string $url;
    private array $urlConjunto;
    private string $urlController;
    private string $urlMetodo;
    private string $urlParametro;
    private string $classe;
    private string $slugController;
    private string $slugMetodo;
    private string $urlLimpa;
    private array $format;

    public function __construct() {

        //Acessando o método da classe Config, para utilizar suas constantes
        $this->configAdm();

        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {

            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            
            echo "Página que o usuário quer acessar: ". $this->url ."<br>";
            
            //Limpando a URL recebida (retirando caracreres especiais etc...)
            $this->url = $this->limparUrl($this->url);
            
            echo "URL Limpa: ". $this->url ."<br>";
            
            #$this->url = $this->limparUrl($this->url);#

            //Transforma a url recebida, em um array
            $this->urlConjunto = explode("/", $this->url);

            echo "<pre>"; var_dump($this->urlConjunto); echo "</pre>"; 

            // Verifica se há um controller e converte para minúsculo
            if (isset($this->urlConjunto[0])) {
                //Coloca o controller(uma classe) em um formato válido
                $this->urlController = $this->slugController($this->urlConjunto[0]);
            } else {
                //Se não existir um controller, o controlle padrão será a constante CONTROLLER (=Login)
                $this->urlController = $this->slugController(CONTROLLER);
            }

            // Verifica se há um método e convete para minúsculo
            if (isset($this->urlConjunto[1])) {
                //Coloca o método(um método) em um formato válido
                $this->urlMetodo = $this->slugMetodo($this->urlConjunto[1]);
            } else {
                //Se o usuário não definir o método, é definido o controller e o método
                //Se não existir um método, o método padrão será a constante METODO (=access)
                $this->urlController = $this->slugController(CONTROLLER);
                $this->urlMetodo = $this->slugMetodo(METODO);
            }

            // Verifica se há um parâmetro
            if (isset($this->urlConjunto[2])) {
                $this->urlParametro = $this->urlConjunto[2];
            } else {
                $this->urlParametro = "";
            }
        } else {
            echo "Criar a página default!<br>";
            $this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParametro = "";
        }

        echo "<br>";
        echo "Controller: {$this->urlController}<br>";
        echo "Método: {$this->urlMetodo}<br>";
        echo "Parâmetro: {$this->urlParametro}<br>";
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

    private function limparUrl($url) {
        //Eliminar as tags
        $this->urlLimpa = strip_tags($url);
        //Eliminar os espaços em branco
        $this->urlLimpa = trim($this->urlLimpa);
        //Eliminar a barra do final da url
        $this->urlLimpa = rtrim($this->urlLimpa, "/");
        //Substituir caracteres especiais por caracteres normais
        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr--------------------------------';
        $this->urlLimpa = strtr(utf8_decode($this->urlLimpa), utf8_decode($this->format['a']), $this->format['b']);
        
        return $this->urlLimpa;
    }

    public function carregar() {
        $carregarPgAdm = new \Core\CarregarPgAdm();
        $carregarPgAdm->carregarPg($this->urlController, $this->urlMetodo, $this->urlParametro);
    }

}

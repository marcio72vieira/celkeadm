<?php

namespace Core;

/**
 * Recebe a URL e manipula
 * @author Marci Vieira <marcio@seati.ma.gov.br>
 */

class ConfigController extends Config {

    /** @var string $url Recebe a url do .htaccess */
    private string $url;
    private array $urlConjunto;
    private string $urlController;
    private string $urlMetodo;
    private string $urlParametro;
    private string $slugController;
    private string $slugMetodo;
    private string $urlLimpa;
    private array $format;

    public function __construct() {

        //Acessando o método da classe Config, para utilizar suas constantes
        $this->configAdm();

        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {

            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            
            //Limpando a URL recebida (retirando caracreres especiais etc...)
            $this->url = $this->limparUrl($this->url);
            
            #$this->url = $this->limparUrl($this->url);#

            //Transforma a url recebida, em um array
            $this->urlConjunto = explode("/", $this->url);

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
            $this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParametro = "";
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

    
    /**
     * @method carregar Intanciar a classe e o método responsável em validar e carregar as páginas
     */
    public function carregar() {
        $carregarPgAdm = new \Core\CarregarPgAdm();
        //Neste momento, o controller, metodo e parâmetro já foram definidos pelo construtor acima
        $carregarPgAdm->carregarPg($this->urlController, $this->urlMetodo, $this->urlParametro);
        
        /*
         * Anteriormente
        //Define o caminho da classe depois de "sanitizada pelo constructor"
        $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
        //Instancia a classe através de um obojeto, seu nome + ()
        $classeCarregar = new $this->classe();
        //Invoca o método da classe, seu nome + ()
        $classeCarregar->{$this->urlMetodo}();
         */
    }

}

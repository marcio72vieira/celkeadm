<?php

namespace Core;

class ConfigView {

    private string $nome;
    private $dados;

    public function __construct($nome, $dados = null) {
        $this->nome = $nome;
        $this->dados = $dados;

        echo "Receber o endereço da VIEW: {$this->nome}<br>";
    }

    public function renderizar() {
        if(file_exists('app/' . $this->nome . '.php')) {
            //Coloca todo o código das views (arquivos.php) aqui,através do include
            include 'app/adms/Views/include/head.php';
            include 'app/' . $this->nome . '.php';
            include 'app/adms/Views/include/footer.php';
        } else {
            //die("Erro (View): Por favor tente novamente. Caso o erro persista, entre em contato com o administrador: ". EMAILADM ."!<br>");
            echo "ERRO ao carregar view: {$this->nome}<br>";
        }
        
    }

}

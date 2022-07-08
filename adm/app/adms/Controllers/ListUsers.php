<?php

namespace App\adms\Controllers;

class ListUsers {
    
    private $dados;


    public function index() {
        $listUsers = new \App\adms\Models\AdmsListUsers();
        $listUsers->listUsers();
        
        if($listUsers->getResultado()) {
            //['listUsers'] é só um index criado arbitrariamente, pois podemos criar outras posições no mesmo
            //nível de '['listUsers];
            $this->dados['listUsers'] = $listUsers->getResultadoBd();
        } else {
            $this->dados['listUsers'] = [];
            //Alternativamente, podemos redirecionar para outra página $urlDestino = URLADM ."login/index"; header("Location: $urlDestino");
        }
        

        //Obs: new \App\adms\core\ConfigView($nome, $dados) que ficque claro: 
        //Primeiro estou instanciando um objeto da classe ConfigView (App\adms\Core\ConfigView),
        //depois, como argumento do construtor eu passo o nome do arquivo de visualização e os dados que eu quero 
        //renderizer no arquivo de visualização ('adms\Views\user\listUser', array_de_dados)
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/listUser", $this->dados);
        $carregarView->renderizar();
    }
}

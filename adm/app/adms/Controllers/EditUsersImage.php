<?php


namespace App\adms\Controllers;


class EditUsersImage {
    
    private $dados;
    private $dadosForm;
    private int $id;
    
    
    public function index($id) {
        $this->id = (int) $id;
        
        $this->dadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        //Verifica se está vindo o ID na URL e o usuário não está tentando editar a imagem. Isso significa que o 
        //usuário só clicou no link editar imagem com o propósito de visualizar a página com a imagem a ser editada,
        //mas não cliquei no botão para efetivar a edição da imagem.
        //Se o resultado desta verificação for false, o usuário está tentando editar e aí executa o ele desta condição
        if(!empty($this->id) AND empty($this->dadosForm['EditUserImagem'])) {
            echo "Só cliquei no link de editar imagem (mas não cliquei no botão para efetivar a edição da imagem)!<br>";
            $viewUser =  new \App\adms\Models\AdmsEditUsersImage();
            $viewUser->viewUser($this->id);
            if($viewUser->getResultado()) {
                $this->dados['form'] =  $viewUser->getResultadoBd();
                $this->viewEditUserImage();
            } else {
                $urlDestino = URLADM ."list-users/index";
                header("Location: $urlDestino");
            }
        } else {
                echo "O botão EditUserImage/Salvar foi acionado! Então é acionado o método editUser()<br>";
                $this->editUser();
                
        }  
    }
    
    private function viewEditUserImage() {
        $carregarView = new \App\adms\core\ConfigView("adms/Views/user/editUserImage", $this->dados);
        $carregarView->renderizar();
    }
    
    // Este método é acionado quando o usuário clicar no botão EditUserImagem na view editUserImage
    private function editUser() {
        if(!empty($this->dadosForm['EditUserImagem'])) {
            //Obs: Os campos do tipo file (image) são recuperados através da variável de array $_FILES e não $_POST. Abaixo, testamos se o array 
            //$_FILE na posição new_image ($_FILE['new_image]) existe e atribuimos o seu próprio valor para a variável $this->dadosForm['new_image']
            //caso contrpario, atribuimos um valor null
            //O valor de $this->dadosForm['new_image'] é um novo array com os índices: name, type, tmp_name, error, size. Abaixo, está descrito como podemos
            //acessar esses outros valores.
            //$this->dadosForm['new_image'] = ($_FILES['new_image'] == true ? $_FILES['new_image'] : null );
            //echo "<pre>"; var_dump($this->dadosForm); echo "</pre>";
            //echo "<pre>"; var_dump($this->dadosForm['new_image']['name']); echo "</pre>";
            
            unset($this->dadosForm['EditUserImagem']);
            $this->dadosForm['new_image'] = ($_FILES['new_image'] == true ? $_FILES['new_image'] : null );
            $editUser =  new \App\adms\Models\AdmsEditUsersImage();
            $editUser->update($this->dadosForm);
            if($editUser->getResultado()) {
                $urlDestino = URLADM ."list-users/index";
                header("Location: $urlDestino");
            } else {
                $this->dados['form'] = $this->dadosForm;
                $this->viewEditUserImage();
            }
            $this->dados['form'] = $this->dadosForm;
            $this->viewEditUserImage();
        } else {
            $_SESSION['msg'] = "Usuário não encontrado!<br>";
            $urlDestino = URLADM ."list-users/index";
            header("Location: $urlDestino");
        }
    }
}

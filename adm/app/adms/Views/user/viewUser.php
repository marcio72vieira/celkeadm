<?php

echo "<h3>Detalhes do Usuário</h3>";
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

/*
echo "<pre>"; var_dump($this->dados); echo "</pre>"; 
Explicando: $this->dados, é um array. $this->dados['viewUser'] é uma posição (índice) criada, dentro do array $this->dados,
            podendo-se criar tantos índices quanto forem necessários. O valor do array $this->dados['viewUser]] é um outro
            array, neste caso, na posição [0], pois é o resultado da consulta no retornada do banco de dados;  Por isso a
            necessidade de na hora de executarmos o extract, termos que especificar a posição exata do que desejamos
            extrair: extract($this->dados['viewUser][0]) */

if(!empty($this->dados['viewUser'])) {
    extract($this->dados['viewUser'][0]);
    echo "ID: ". $id ."<br>";
    echo "Nome: ". $name ."<br>";
    echo "E-mail: ". $email ."<br>";
    echo "<a href='". URLADM ."edit-users-password/index/$id'>Editar Senha</a>";
    
}
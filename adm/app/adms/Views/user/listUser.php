<?php

echo "<h3>Listar Usuários</h3>";

echo "<a href='". URLADM ."add-users/index'>Cadastrar</a><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

echo "<hr>";

//echo "<pre>"; var_dump($this->dados); echo "</pre>";
foreach ($this->dados['listUsers'] as $user) {
    extract($user);
    echo "ID: " . $id . "<br>";
    echo "Nome: " . $name . "<br>";
    echo "E-mail: " . $email . "<br>";
    echo "<a href='". URLADM ."view-users/index/$id'>Visualizar</a>";
    echo "<hr>";
}
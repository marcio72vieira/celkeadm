<?php

echo "<h3>Listar Usuários</h3>";
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

//echo "<pre>"; var_dump($this->dados); echo "</pre>";
foreach ($this->dados['listUsers'] as $user) {
    echo "ID: " . $user['id'] . "<br>";
    echo "Nome: " . $user['name'] . "<br>";
    echo "E-mail: " . $user['email'] . "<br>";
    echo "<hr>";
}
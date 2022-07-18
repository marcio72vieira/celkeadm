<?php

//Logo que essa view for carregada, dados['form'] não existirá
if(isset($this->dados['form'])){
    $valorForm = $this->dados['form'];
}

echo "<h3>Cadastrar Usuário</h3>";



if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>


<!-- Div para exibir mensagens de error -->
<span class="msg"></span>

<!-- Este formulário será submetido para o controller NewUser.php, ou seja, para a própria página, visto que o action está vazio!  -->
<form id="add_user" method="POST" action="" autocomplete="off">
    <label>Nome</label>
    <input name="name" type="text" id="name" placeholder="Nome completo" value="<?php if(isset($valorForm['name'])){ echo $valorForm['name']; } ?>" ><br><br>
    <label>Email</label>
    <input name="email" type="text" id="email" placeholder="Melhor e-mail" value="<?php if(isset($valorForm['email'])){ echo $valorForm['email']; } ?>" ><br><br>
    <label>Usuário</label>
    <input name="username" type="text" id="username" placeholder="Usuário para acessar o login" value="<?php if(isset($valorForm['username'])){ echo $valorForm['username']; } ?>" ><br><br>
    <label>Senha</label>
    <input name="password" type="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()"><br>
    <span id="msgViewStrength"></span><br><br>
    <input name="AddUser" type="submit" value="Cadastrar">
</form>


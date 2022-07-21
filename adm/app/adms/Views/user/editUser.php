<?php
//Logo que essa view for carregada, dados['form'] não existirá
if(isset($this->dados['form'])){
    $valorForm = $this->dados['form'];
}

if(isset($this->dados['form'][0])){
    $valorForm = $this->dados['form'][0];
}

//echo "<pre>"; var_dump($this->dados['form']); echo "</pre>";

echo "<h3>Editar o Usuário</h3>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<!-- Div para exibir mensagens de error -->
<span class="msg"></span>

<!-- Este formulário será submetido para o controller NewUser.php, ou seja, para a própria página, visto que o action está vazio!  -->
<form id="edit_user" method="POST" action="" autocomplete="off">
    <!-- Cria-se um campo oculto com a finalidade de recuperá-lo pra compor o WHERE do registro a ser atualizado -->
    <input name="id" type="hidden" id="id" value="<?php if(isset($valorForm['id'])){ echo $valorForm['id']; } ?>">
    <label>Nome</label>
    <input name="name" type="text" id="name" placeholder="Nome completo" value="<?php if(isset($valorForm['name'])){ echo $valorForm['name']; } ?>" ><br><br>
    <label>Apelido</label>
    <input name="nickname" type="text" id="nickname" placeholder="Apelido" value="<?php if(isset($valorForm['nickname'])){ echo $valorForm['nickname']; } ?>" ><br><br>
    <label>Email</label>
    <input name="email" type="text" id="email" placeholder="Melhor e-mail" value="<?php if(isset($valorForm['email'])){ echo $valorForm['email']; } ?>" ><br><br>
    <label>Usuário</label>
    <input name="username" type="text" id="username" placeholder="Usuário para acessar o login" value="<?php if(isset($valorForm['username'])){ echo $valorForm['username']; } ?>" ><br><br>

    <input name="EditUser" type="submit" value="Salvar">
</form>


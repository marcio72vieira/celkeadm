<?php
    //Logo que essa view for carregada, dados['form'] não existirá
    if(isset($this->dados['form'])){
        $valorForm = $this->dados['form'];
    }
?>

<h1>Novo Usuário</h1>

<?php
    if(isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
?>


<!-- Este formulário será submetido para o controller NewUser.php, ou seja, para a própria página, visto que o action está vazio!  -->
<form method="POST" action="">
    <label>Nome</label>
    <input name="name" type="text" id="name" placeholder="Digite o nome" value="<?php if(isset($valorForm['name'])){ echo $valorForm['name']; } ?>" ><br><br>
    <label>Email</label>
    <input name="email" type="text" id="email" placeholder="Digite o seu melhor e-mail" value="<?php if(isset($valorForm['email'])){ echo $valorForm['email']; } ?>" ><br><br>
    <label>Senha</label>
    <input name="password" type="password" id="password" placeholder="Digite a senha" ><br><br>
    <input name="SendNewUser" type="submit" value="Cadastrar">
</form>

<!--Link aprontando para o controller e método, através da concatenação com a constante URLADM. É necessário acrescentar a
    classe NewUser, no array de paǵinas públicas, localizado no método: pgPublica(), localizado na classe: core\CarregarPgAdmin-->
<p><a href="<?php echo URLADM; ?>login/index">Clique aqui</a> para acessar!</p>






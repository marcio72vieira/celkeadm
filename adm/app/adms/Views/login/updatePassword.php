<?php
    //Logo que essa view for carregada, dados['form'] não existirá
    if(isset($this->dados['form'])){
        $valorForm = $this->dados['form'];
    }
    //Criptografar a senha temporariamente
    //echo password_hash(123456, PASSWORD_DEFAULT);
?>

<h1>Atualizar a Senha!</h1>


<?php
    if(isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
?>

<!--
    O action = "", significa que iremos submeter o formulário para esse próprio script. Só lembrando que esse
    script é incluso dentro da classe ConfigView.php e a classe ConfigView.php é instanciada pela classe
    controlle Login.php (e esta, verifica se foram enviados dados através deste formulário para instanciar o
    Model [admsLogin]), ou seja, é como se os arquivos access.php, ConfigView.php e Login.php estivessem todos
    reunidos em um único arquivo, por isso podemos acessar variáveis que estejam em quaisquer um desses scripts.
    Esta lógica, serve para todas as demais views existentes neste projeto.
-->

<!-- Div para exibir mensagens de error -->
<span class="msg"></span>

<form id="update_password" method="POST" action="">
    <label>Senha</label>
    <input name="password" type="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" ><br><br>
    <span id="msgViewStrength"></span><br><br>
    <input name="upPassword" type="submit" value="Salvar">
</form>

<!--Link aprontando para o controller e método, através da concatenação com a constante URLADM. É necessário acrescentar
    no array de paǵinas públicas, localizado no método: pgPublica(), localizado na classe: core\CarregarPgAdmin-->
<br>
<p>
    <a href="<?php echo URLADM; ?>login/index">Acessar</a> <br>
</p>


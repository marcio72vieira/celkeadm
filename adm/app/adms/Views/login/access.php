<?php
    if(isset($this->dados['form'])){
        $valorForm = $this->dados['form'];
        echo "<pre>";
            var_dump($valorForm);
        echo "</pre>";
           
    }
    
    //Criptografar a senha temporariamente
    //echo password_hash(123456, PASSWORD_DEFAULT);
?>

<h1>Acesso Restrito</h1>

<form method="POST" action="">
    <label>Usuário</label>
    <input name="user" type="text" id="user" placeholder="Digite o usuário" value="<?php if(isset($valorForm['user'])){ echo $valorForm['user']; } ?>" ><br><br>
    <label>Senha</label>
    <input name="password" type="password" id="password" placeholder="Digite a senha" ><br><br>
    <input name="sendLogin" type="submit" value="Acessar">
</form>

<?php
//Logo que essa view for carregada, dados['form'] não existirá
if(isset($this->dados['form'])){
    $valorForm = $this->dados['form'];
}

if(isset($this->dados['form'][0])){
    $valorForm = $this->dados['form'][0];
}

//echo "<pre>"; var_dump($this->dados['form']); echo "</pre>";

echo "<h3>Editar a Imagem do Usuário</h3>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<!-- Div para exibir mensagens de error -->
<span class="msg"></span>

<!-- Este formulário será submetido para o controller EditUsersImage.php, ou seja, para a própria página, visto que o action está vazio!  -->
<form id="" method="POST" action="" autocomplete="off" enctype="multipart/form-data">
    <!-- Cria-se um campo oculto com a finalidade de recuperá-lo pra compor o WHERE do registro a ser atualizado -->
    <input name="id" type="hidden" id="id" value="<?php if(isset($valorForm['id'])){ echo $valorForm['id']; } ?>">
    <label>Imagem:*</label>
    <input name="new_image" type="file" id="new_image"><br><br>
    <p>( * ) Campos obrigatórios</p><br>
    
    
    <input name="EditUserImagem" type="submit" value="Salvar">
</form>


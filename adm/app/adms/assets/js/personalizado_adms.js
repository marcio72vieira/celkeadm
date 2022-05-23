//Quando carregar o documento, execute uma função para validar Cadastro de Usuário
$(document).ready(function () {
    //Quando houver uma interação (on) do tipo "submit" no formulário, execute uma função. A função captura o objeto "event"
    $("#new_user").on("submit", function(event) {
        //event.preventDefault();
       
        //Testa se os valores(val) dos campos, através de seus respectivos "id's" está vazio. Se estiveror vazio, 
        //irá inserir no conteúdo de um elemento(<span> no caso), cuja classe é =".msg", uma frase envolta em tags(<p>) html
        if($("#name").val() === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo nome</p>");
            return false;
        } else if($("#email").val() === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo email</p>");
            return false;
        } else if($("#password").val() === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo senha</p>");
            return false;
        }
    });
});


//Quando carregar o documento, execute uma função para validar Login do Usuário
$(document).ready(function () {
    //Quando houver uma interação (on) do tipo "submit" no formulário, execute uma função.
    $("#send_login").on("submit", function() {
        
        //Testa se os valores(val) dos campos, através de seus respectivos "id's" está vazio. Se estiveror vazio, 
        //irá inserir no conteúdo de um elemento(<span> no caso), cuja classe é =".msg", uma frase envolta em tags(<p>) html
        if($("#user").val() === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo usuário</p>");
            return false;
        } else if($("#password").val() === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo senha</p>");
            return false;
        }
    });
});


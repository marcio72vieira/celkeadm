//FUNÇÕES ENVOLVENDO O JQUERY
//Quando carregar o documento, execute uma função para validar Cadastro de Usuário
$(document).ready(function () {
    //Quando houver uma interação (on) do tipo "submit" no formulário, execute uma função. A função captura o objeto "event"
    $("#new_user").on("submit", function(event) {
        //event.preventDefault();
        var password = $("#password").val();
       
        //Testa se os valores(val) dos campos, através de seus respectivos "id's" está vazio. Se estiveror vazio, 
        //irá inserir no conteúdo de um elemento(<span> no caso), cuja classe é =".msg", uma frase envolta em tags(<p>) html
        if($("#name").val() === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo nome</p>");
            return false;
        } else if($("#email").val() === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo email</p>");
            return false;
        } else if(password === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo senha</p>");
            return false;
        } else if(password.length < 6 || password.match(/([1-9]+)\1{1,}/)) {
            $(".msg").html("<p style='color: #ff0000'>Erro: senha muito franca, não deve ter número repedito</p>");
            return false;
        } else if(password.length < 6 || !password.match(/([A-Za-z])/)) {
            $(".msg").html("<p style='color: #ff0000'>Erro: senha muito franca, deve ter número pelo menos uma letra</p>");
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
        if($("#username").val() === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo usuário</p>");
            return false;
        } else if($("#password").val() === "") {
            $(".msg").html("<p style='color: #ff0000'>Erro: É necessário preencher o campo senha</p>");
            return false;
        }
    });
});


//FUNÇÕES ENVOLVENDO O JAVASCRIPT PURO
function passwordStrength() {
    
    //Obtém o que foi digitado no campo senha (password)
    var password = document.getElementById('password').value;
    var strength = 0;
    
    //Se a quantidade de caracteres é de 6 a 7 a força obtém 10, sendo 8 ou mais, obtém 25
    if((password.length >=6) && (password.length <=7)) {
        strength += 10;
    }else if (password.length > 7) {
        strength += 25;
    }
    
    //Verifica se a senha é maior igual a 6 e se o usuário digitou algum caracter de "a" a "z" minúsculo
    //acrescenta o valor de 10 ao valor de strength
    if((password.length >=6) && (password.match(/[a-z]/))) {
        strength += 10;
    }
    
    //Verifica se a senha é maior igual a 7 e se o usuário digitou algum caracter de "A" a "Z" MAIÚSCULO
    //acrescenta o valor de 20 ao valor de strength
    if((password.length >=7) && (password.match(/[A-Z]/))) {
        strength += 20;
    }
    
    //Verifica se a senha é maior igual a 8 e se o usuário digitou os seguintes caracteres @ # $ % & ; *
    //acrescenta o valor de 20 ao valor de strength
    if((password.length >=8) && (password.match(/[@#$%&;*]+/))) {
        strength += 25;
    }
    
    //Verifica se o usuário digitou dois caracteres iguais um atrás do outro, independente de quantos caracteres
    //ele digitou
    if(password.match(/([1-9]+)\1{1,}/)) {
        strength -= 25;
    }
    
    console.log("Senha: " +  document.getElementById("password").value + "   Força: " + strength);
    
    viewStrength(strength);
}

/*Exibir a força da senha*/
function viewStrength(strength) {
    if(strength < 30) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #ff0000'>Senha fraca!</p>";
    }else if (strength >= 30 && strength < 50) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #ff8c00'>Senha média!</p>";
    }else if (strength >= 50 && strength < 70) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #7cfc00'>Senha boa!</p>";
    }else if (strength >= 70 && strength < 100) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #008000'>Senha forte!</p>";
    }
}


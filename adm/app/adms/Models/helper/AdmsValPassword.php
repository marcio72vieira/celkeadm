<?php

namespace App\adms\Models\helper;

class AdmsValPassword {

    private string $password;
    private bool $resultado;

    public function getResultado(): bool {
        return $this->resultado;
    }

    public function validarPassword($password) {

        $this->password = (string) $password;

        //Obs: Pode-se utilizar um array de caracteres que não se quer que o usuário utilize
        //Vefificando se o usuário digitou (') aspas simples na senha
        if (stristr($this->password, "'")) {
            $_SESSION['msg'] = "Erro: Caracter (') utilizado na senha, inválido!";
            $this->resultado = false;
        } else {
            //Vefificando se o usuário digitou (" ") espaço em branco na senha
            if (stristr($this->password, " ")) {
                $_SESSION['msg'] = "Erro: Proibido utilizar espaço em branco no campo senha!";
                $this->resultado = false;
            } else {
                //Valida a extensão da senha
                $this->valExtensPassword();
            }
        }
    }

    private function valExtensPassword() {
        if (strlen($this->password) < 6) {
            $_SESSION['msg'] = "Erro: A senha deve ter no mínimo 6 caracteres!";
            $this->resultado = false;
        } else {
            $this->valValuePassword();
        }
    }
    
    //Inicia e finaliza uma exressão regular '/^ $/'
    private function valValuePassword() {
        if (preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]{6,}$/', $this->password)) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "Erro: A senha deve ter letras e números!";
            $this->resultado = false;
        }
    }

}

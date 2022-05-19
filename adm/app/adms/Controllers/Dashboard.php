<?php

namespace App\adms\Controllers;

class Dashboard {

    public function index() {

        echo "BEM VINDO ". $_SESSION['user_name'] ."<br>";

    }

}

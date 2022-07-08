<?php

namespace App\adms\Controllers;

class Dashboard {

    public function index() {

        $carregarView = new \App\adms\core\ConfigView("adms/Views/dashboard/home");
        $carregarView->renderizar();

    }

}

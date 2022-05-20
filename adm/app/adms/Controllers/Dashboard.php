<?php

namespace App\adms\Controllers;

class Dashboard {

    public function index() {

        $carregarView = new \Core\ConfigView("adms/Views/dashboard/home");
        $carregarView->renderizar();

    }

}

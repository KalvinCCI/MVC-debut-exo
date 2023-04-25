<?php

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {

        extract($data);

        // On démarre le buffer de sortie
        ob_start();

            include_once ROOT."/views/$view.php";

        // On décharge le buffer de sortie
        $contenu = ob_get_clean();

        include_once ROOT.'/views/base.php';
    }
}
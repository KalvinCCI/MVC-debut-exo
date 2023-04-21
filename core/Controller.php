<?php

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {

        extract($data);

        include_once ROOT."/views/$view.php";
    }
}
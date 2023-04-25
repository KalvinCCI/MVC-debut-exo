<?php

use App\Autoloader;
use App\Core\Main;

// On défini la constante avec le dossier racine du projet
define('ROOT', dirname(__DIR__));

include_once ROOT.'/Autoloader.php';

Autoloader::register();

// On instancie la classe Main qi va démarrer notre application (et le routeur)
$app = new Main();

// On execute la méthode start qui démarre notre app
$app->start();

?>
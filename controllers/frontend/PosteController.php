<?php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Core\Route;

class PosteController extends Controller
{
    #[Route('poste.show', '/poste/details/([0-9]+)', ['GET'])]
    public function showPoste(int $id): void
    {
        echo 'Poste Detail';
    }
}
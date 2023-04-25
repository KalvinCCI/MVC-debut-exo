<?php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Core\Route;
use App\Models\PosteModel;

class PosteController extends Controller
{
    #[Route('poste.show', '/postes/details/([0-9]+)', ['GET'])]
    public function showPoste(int $id): void
    {
        $poste = new PosteModel();

        $this->render('frontend/poste/show', [
            'poste' => $poste->find($id)
        ]);
    }
}
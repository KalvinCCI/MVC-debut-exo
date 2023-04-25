<?php

namespace App\Controllers\Frontend;
use App\Core\Route;
use App\Core\Controller;
use App\Models\PosteModel;

class MainController extends Controller
{
    #[Route('homepage','/', ['GET'])]
    public function index(): void
    {
        $postes = new PosteModel();

        $this->render('frontend/index',[
            'postes' => $postes->findAll()
        ]);
    }

    


}
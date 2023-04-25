<?php

namespace App\Controllers\Frontend;
use App\Core\Route;
use App\Core\Controller;
use App\Models\PosteModel;
use App\Core\Form;

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

    #[Route('login','/login', ['GET', 'POST'])]
    public function login(): void
    {
        $form = (new Form())
            ->startForm('#', 'POST', [
                'class' => 'form card p-3 w-50 mx-auto',
                'id' => 'form-login'
            ])
            ->startDiv(['class'=>'mb-3'])
            ->addLabel('email', 'Email :', ['class'=>'form-label'])
            ->addInput('email', 'email', ['class' => 'form-control', 'id' => 'email', 'placeholder'=>'johnDoe@exemple.com'])
            ->endDiv()
            ->startDiv(['class'=>'mb-3'])
            ->addLabel('password', 'Mot de passe :', ['class' => 'form-label'])
            ->addInput('password', 'password', ['class'=>'form-control','id'=>'password'])
            ->endDiv()
            ->addButton('Connexion', ['type'=>'submit', 'class'=>'btn btn-primary'])
            ->endForm();

        $this->render('frontend/login', ['form' => $form->createForm()]);
    }

}
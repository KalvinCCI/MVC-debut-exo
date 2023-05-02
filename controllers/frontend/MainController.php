<?php

namespace App\Controllers\Frontend;
use App\Core\Route;
use App\Core\Controller;
use App\Models\PosteModel;
use App\Core\Form;
use App\Models\UserModel;

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
        if (Form::validate($_POST, ['email', 'password'])) {
            $user = new UserModel();
            $userDb = $user->findUserByEmail($_POST['email']);

            if (!$userDb) {
                $_SESSION['message']['error'] = 'Identifiants invalides';
                header('Location: /login');
                exit();
            }
            $user->hydrate($userDb);
            
            if (password_verify($_POST['password'], $user->getPassword())) {
                $user->setSession();
                header('Location: /');
                exit();
            } else {
                $_SESSION['message']['error'] = 'Identifiants invalides';
                header('Location: /login');
                exit();
            }

        }

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

    #[Route('register', '/register', ['GET', 'POST'])]
    public function register(): void
    {
        if (Form::validate($_POST, ['nom', 'prenom', 'email', 'passwrd'])) {
            // Le formulaire est soumi et valide
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = password_hash($_POST['passwrd'], PASSWORD_ARGON2I);

            $user = (new UserModel())
                ->setNom($nom)
                ->setPrenom($prenom)
                ->setEmail($email)
                ->setPassword($password)
            ;

            $user->create();

            $_SESSION['message']['success']  = 'Vous êtes bien inscrit à notre application';

            header('Location: /login');
            exit();
        }

        $form = (new Form())
            ->startForm('#', 'POST', ['class'=>'form card p-3 w-75 mx-auto'])
            ->startDiv(['class'=>'mb-3 row'])
                ->startDiv(['class'=>'col-12 col-md-6'])
                    ->addLabel('nom', 'Nom :', ['class'=>'form-label'])
                    ->addInput('text', 'nom', ['class'=>'form-control', 'required'=>true, 'id'=>'nom', 'placeholder'=>'Doe'])
                ->endDiv()
                ->startDiv(['class'=>'col-12 col-md-6'])
                    ->addLabel('prenom', 'Prenom :', ['class'=>'form-label'])
                    ->addInput('text', 'prenom', ['class'=>'form-control', 'required'=>true, 'id'=>'prenom', 'placeholder'=>'John'])
                ->endDiv()
            ->endDiv()
            ->startDiv(['class'=>'mb-3'])
                ->addLabel('email', 'Email :', ['class'=>'form-label'])
                ->addInput('email', 'email', ['class'=>'form-control', 'required'=>true, 'id'=>'email', 'placeholder'=>'john@example.com'])
            ->endDiv()
            ->startDiv(['class'=>'mb-3'])
                ->addLabel('passwrd', 'Mot de passe :', ['class'=>'form-label'])
                ->addInput('password', 'passwrd', ['class'=>'form-control', 'required'=>true, 'id'=>'passwrd', 'placeholder'=>'S3CR3T'])
            ->endDiv()
            ->addButton('S\'inscrire', ['class'=>'btn btn-primary mt-3'])
            ->endForm()
        ;

        $this->render('frontend/register', ['form'=>$form->createForm()]);
    }

    #[Route('logout', '/logout', ['GET'])]
    public function logout(): void
    {
        unset($_SESSION['user']);
        header("Location: $_SERVER[HTTP_REFERER]");
        exit();
    }
}
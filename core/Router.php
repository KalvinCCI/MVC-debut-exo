<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function addRoute(array $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    public function handleRequest(string $url, string $method)
    {
        // On boucle sur le tableau des routes de mon application
        foreach ($this->routes as $route) {
            // On vérifie que l'url envoie du navigateur et la methode correspondent a une route existante
            if (preg_match('#^'. $route['url'].'$#', $url, $matches) && in_array($method, $route['methods'])) {
                
                /**
                 * [
                 *   'url' => '/',
                 *   'method' => ['GET'],
                 *   'controller' => 'App\Controller\MainController'
                 * ]
                 */
                $controller = $route['controller'];
                $action = $route['action'];

                // new App\Controller\HomeController();
                $controller = new $controller();
                $params = array_slice($matches,1 );
                $controller->$action(...$params);

                // showPoste(1)


                return;
            }
        }

        http_response_code(404);
        echo 'Page not Found';
    }
}
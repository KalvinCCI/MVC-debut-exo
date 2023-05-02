<?php

namespace App\Core;

class Main
{
    public function __construct(
        private Router $router = new Router()
    ) {
    }

    public function start(): void
    {
        session_start();

        $uri = $_SERVER['REQUEST_URI'];

        if ($uri != '/' && !empty($uri) && $uri[-1] === '/') {
            $uri = substr($uri, 0, -1);

            // On envoie le http 301
            http_response_code(301);

            // On redirige le navigateur 
            header("Location: $uri");
            exit();
        }
        
        $this->initRouter();

        $this->router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

    private function initRouter(): void
    {
        $files = glob(\dirname(__DIR__). '/controllers/{*/,}*.php',GLOB_BRACE);

        foreach ($files as $file) {
            $file = \substr($file, 1);
            $file = \str_replace('/', '\\', $file);
            $file = \substr($file, 0, -4);
            $file = \ucwords($file, '\\');

            $classes[] = $file;
        }

        foreach ($classes as $class) {
            $methods = get_class_methods($class);
            foreach ($methods as $method) {
                $attributes = (new \ReflectionMethod($class, $method))->getAttributes(Route::class);
               
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $route
                        ->setController($class)
                        ->setAction($method);
                    $this->router->addRoute([
                        'name' => $route->getName(),
                        'url' => $route->getUrl(),
                        'methods' => $route->getMethods(),
                        'controller' => $route->getController(),
                        'action' => $route->getAction()
                    ]);
                }
            }
        }
    }
}

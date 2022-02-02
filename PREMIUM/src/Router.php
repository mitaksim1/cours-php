<?php
namespace app;

class Router 
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function resolve()
    {
        // S'il n'y aucun chemin dans la clé PATH_INFO, afficher route /
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        // On doit savoir quelle méthode a été utilisée
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            // La fonction correspondra à la route trouvé dans la variable $currentUrl, soit /, /update
            // On vérifie aussi si la route existe
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            // Si la méthode n'est pas GET elle est forcément POST
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if ($fn) {
            echo '<pre>';
            var_dump($fn);
            echo '</pre>';
        } else {
            echo "Page not found";
        }
    }
}
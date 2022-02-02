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
        echo '<pre>';
        var_dump($_SERVER);
        echo '</pre>';
        // S'il n'y aucun chemin dans la clé PATH_INFO, afficher route /
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
    }
}
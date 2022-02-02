<?php
namespace app\controllers;

use app\Router;

class ProductController 
{
    // Render the list of products
    // On a accès à Router grâce au deuxième paramètre passé à la fonction call_user_func dans Router.php
    public function index(Router $router)
    {
        $router->renderView('products/index');
    }

    public function create()
    {
        echo "Create Page";
    }

    public function update()
    {
        echo "Update page";
    }

    public function delete()
    {
        echo "Delete page";
    }
}
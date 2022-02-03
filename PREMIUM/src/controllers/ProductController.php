<?php
namespace app\controllers;

use app\Router;

class ProductController 
{
    // Render the list of products
    // On a accès à Router grâce au deuxième paramètre passé à la fonction call_user_func dans Router.php
    public function index(Router $router)
    {
        $search = $_GET['search'] ?? '';

        // Requête à la bdd
        $products = $router->db->getProducts($search);

        // Vérification si données ok avant l'envoi à la vue
        // $router->dump($products);

        // On envoit les produits en forme de tableau à la vue
        // Il faut ajouter ce deuxième paramètre à la méthode renderView cf. Router::renderView
        $router->renderView('products/index', [
            'products' => $products,
            'search' => $search
        ]);
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
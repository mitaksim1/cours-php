<?php
namespace app\controllers;

use app\Router;
use app\models\Product;

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

    public function create(Router $router)
    {
        $errors = [];
        $productData = [
            'title' => '',
            'description' => '',
            'image' => '',
            'price' => ''
        ];

        // Validation avant d'envoyer les données en bdd
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On récupère les valeurs passées au form grâce à la super global $_POST
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            // Pour éviter des erreurs on peut préciser le type de données attendues
            $productData['price'] = (float)$_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            // Instanciation du model Product
            $product = new Product();
            // On lui passe toutes les données récupérées avec la méthode load
            $product->load($productData);
            // save() : méthode à créer
            $errors = $product->save();
            if (empty($errors)) {
                header('Location: /products');
                exit;
            }  
        }
       
        $router->renderView('products/create', [
            'product' => $productData,
            'errors' => $errors
        ]);
    }

    public function update(Router $router)
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /products');
            exit;
        }

        $errors = [];
        $productData = $router->db->getProductById($id);

        // Si la méthode envoyé est POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // On veut "populate" les valeurs passées dans la page
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            // Pour éviter des erreurs on peut préciser le type de données attendues
            $productData['price'] = (float)$_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            // Instanciation du model Product
            $product = new Product();
            // On lui passe toutes les données récupérées avec la méthode load
            $product->load($productData);
            // save() : méthode à créer
            $errors = $product->save();
            if (empty($errors)) {
                header('Location: /products');
                exit;
            }  
        }

        $router->renderView('products/update', [
            'product' => $productData,
            'errors' => $errors
        ]);
    }

    public function delete(Router $router)
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: /products');
            exit;
        }
        $router->db->deleteProduct($id);
        header('Location: /products');
            exit;
    }
}
<?php
// Fichier d'entrée du projet : c'est ce fichier qui va gérer les requêtes et rendre les réponses
// Les routes seront créés ici aussi

require_once __DIR__.'/../vendor/autoload.php';

use app\Router;
use app\controllers\ProductController;

$router = new Router();

// si la route demandée est /, appeler la méthode index du controller ProductController
$router->get('/', [ProductController::class, 'index']);
$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/create', [ProductController::class, 'create']);
$router->post('/products/create', [ProductController::class, 'create']);
$router->get('/products/update', [ProductController::class, 'update']);
$router->post('/products/update', [ProductController::class, 'update']);
$router->post('/products/delete', [ProductController::class, 'delete']);

$router->resolve();
<?php
namespace app;

class Router 
{
    public array $getRoutes = [];
    public array $postRoutes = [];
    public Database $db;

    // On crée une instance de Database dès l'instanciation de Router
    public function __construct()
    {
        $this->db = new Database();
    }

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function dump($value)
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }

    // Retourne la page demandée
    public function resolve()
    {
        // S'il n'y aucun chemin dans la clé PATH_INFO, afficher route /
        $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
        if (strpos($currentUrl, '?') !== false) {
            $currentUrl = substr($currentUrl, 0, strpos($currentUrl, '?'));
        }
        
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
            // Execute la fonction lui passé en paramètre
            // $this : on passe l'objet Router comme paramètre à la fonction qui sera appelé par call_user_func
            call_user_func($fn, $this);
        } else {
            echo "Page not found";
        }    
    }

    // Retourne la vue passée en paramètre
    public function renderView($view, $params = []) // products/index
    {
        foreach ($params as $key => $value) {
            // $key = 'products'
            // $$key = $value -> l'ajout du $ devant la variable $key transforme sa valeur string ('products') en une variable ($products)
            // $products = $value 
            $$key = $value;
        }
        // Save the content of an include or echo in the local buffer
        ob_start();
        // Inclut la vue passée en argument
        include_once __DIR__."/views/$view.php";
        // Return the output and clean the buffer
        $content = ob_get_clean();
        
        // Affiche le contenu de $content dans la partie spécifée dans _layout.php
        include_once __DIR__.'/views/_layout.php';
    }
}

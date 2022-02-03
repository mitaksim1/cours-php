<?php

namespace app;

use PDO;
use app\models\Product;

class Database
{
    public \PDO $pdo;
    public static Database $db;

    public function __construct()
    {
        // Connexion avec PDO
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'mimi', 'Mimi182123*');   
        // Si problème avec la connexion, cette config va nous retourner un message d'erreur
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

    public function getProducts($search = '')
    {
        if ($search) {
          $statement = $this->pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
          // Cette notation avec %% permet de récupérer toutes les occurences avec le mot cherché
          $statement->bindValue(':title', "%$search%");
        } else {
          $statement = $this->pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function createProduct(Product $product)
    {
      // On crée des variables pour plus de sécurité, ça empêche de recevoir des injections SQL
      $statement = $this->pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                                   VALUES (:title, :image, :description, :price, :date)");

      // On précise à PDO à quoi correspondent les variables créées
      $statement->bindValue(':title', $product->title);
      $statement->bindValue(':image', $product->imagePath);
      $statement->bindValue(':description', $product->description);
      $statement->bindValue(':price', $product->price);
      $statement->bindValue(':date', date('Y-m-d H:i:s'));
      $statement->execute();
    }
}

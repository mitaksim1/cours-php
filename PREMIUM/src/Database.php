<?php

namespace app;

use PDO;

class Database
{
    public \PDO $pdo;

    public function __construct()
    {
        // Connexion avec PDO
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'mimi', 'Mimi182123*');
           
        // Si problème avec la connexion, cette config va nous retourner un message d'erreur
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
}
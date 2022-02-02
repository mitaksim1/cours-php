<?php
require_once "../../database.php";
require_once '../../functions.php';

// On peut comme on peut ne pas récupérer l'id, alors il faut prévoir cette possibilité
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($product);
// echo '</pre>';
// exit;

// Pour capturer les erreurs, on crée une variable du type array qui va les stocker d'abord
$errors = [];

// Récupérations des données retournées par la requête
$title = $product['title'];
$price = $product['price'];
$description = $product['description'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once "../../validate_product.php"; 
    

    // On n'enregistre les données que s'il n'y a pas des erreurs
    if (empty($errors)) {
     
      // On crée des variables pour plus de sécurité, ça empêche de recevoir des injections SQL
      $statement = $pdo->prepare("UPDATE products SET title = :title, image = :image, description = :description, price = :price WHERE id = :id");
                                
      // On précise à PDO à quoi correspondent les variables créées
      $statement->bindValue(':title', $title);
      $statement->bindValue(':image', $imagePath);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':id', $id);
      $statement->execute();

      // Redirection après sauvegarde du produit dans la bdd
      header('Location: index.php');
    }   
}
?>
<!-- HEADER -->
 <?php include_once "../../views/partials/header.php"; ?>   

    <div class="container">
      <p>
          <a href="index.php" class="btn btn-secondary">Go back to Products</a>
      </p>

      <h1>Update product : <b><?php echo $product['title'] ?></b></h1>
      <!-- FORM -->
      <?php include_once "../../views/products/form.php"; ?>
    
    </div>    
  </body>
</html>





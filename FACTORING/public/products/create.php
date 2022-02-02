<?php
require_once "../../database.php";
require_once '../../functions.php';

// Pour capturer les erreurs, on crée une variable du type array qui va les stocker d'abord
$errors = [];

// Déclaration des variables pour éviter des erreurs à l'appel au niveau du HTML
$title = '';
$price = '';
$description = '';
$product = ['image' => ''];

// On récupère les informations passés dans le formulaire grâce à $_POST
// On vérifie d'abord si les informations envoyées sont envoyées avec la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "../../validate_product.php";

    // On n'enregistre les données que s'il n'y a pas des erreurs
    if (empty($errors)) {
      // On crée des variables pour plus de sécurité, ça empêche de recevoir des injections SQL
      $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                                   VALUES (:title, :image, :description, :price, :date)");

      // On précise à PDO à quoi correspondent les variables créées
      $statement->bindValue(':title', $title);
      $statement->bindValue(':image', $imagePath);
      $statement->bindValue(':description', $description);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':date', date('Y-m-d H:i:s'));
      $statement->execute();

      // Redirection après sauvegarde du produit dans la bdd
      header('Location: index.php');
    }   
}
?>

<?php include_once "../../views/partials/header.php"; ?>  

  
    <div class="container">
      <p>
          <a href="index.php" class="btn btn-secondary">Go back to Products</a>
      </p>

        <h1>Create new product</h1>

        <!-- FORM -->
        <?php include_once "../../views/products/form.php"; ?>
    </div>  
  </body>
</html>




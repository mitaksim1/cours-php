<?php
// Connexion avec PDO
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'mimi', 'Mimi182123*');

// Si problème avec la connexion, cette config va nous retourner un message d'erreur
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Pour capturer les erreurs, on crée une variable du type array qui va les stocker d'abord
$errors = [];

// On récupère les informations passés dans le formulaire grâce à $_POST
// On vérifie d'abord si les informations envoyées sont envoyées avec la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    // Pour récupérer la date du jour, on appelle date() en lui passant le format attendue par MySQL
    $date = date('Y-m-d H:i:s');


    // Validations
    if (!$title) {
      $errors[] = 'Product title is required';
    }
    if (!$price) {
      $errors[] = 'Product price is required';
    }

    // On n'enregistre les données que s'il n'y a pas des erreurs
    if (empty($errors)) {
      // On crée des variables pour plus de sécurité, ça empêche de recevoir des injections SQL
      $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                                   VALUES (:title, :image, :description, :price, :date)");
                                   
      // On précise à PDO à quoi correspondent les variables créées
      $statement->bindValue(':title', $title);
      $statement->bindValue(':image', '');
      $statement->bindValue(':description', $description);
      $statement->bindValue(':price', $price);
      $statement->bindValue(':date', $date);
      $statement->execute();
    }    
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Products CRUD</title>
  </head>
  <body>    
    <!-- FORM -->
    <div class="container">
        <h1>Create new product</h1>

        <!-- Message d'erreur si donnée manquante  -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $error): ?>
                <div><?php echo $error ?></div>
              <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="post">
          <div class="form-group mb-3">
            <label>Product Image</label>
            <br>
            <input type="file" name="image">
          </div>
          
          <div class="form-group mb-3">
            <label>Product Title</label>
            <input type="text" name="title" class="form-control">
          </div>
          
          <div class="form-group mb-3">
            <label>Product Description</label>
            <textarea type="text" name="description" class="form-control"></textarea>
          </div>

          <div class="form-group mb-3">
            <label>Product Price</label>
            <input type="number" name="price" step="0.1" class="form-control">
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>  
  </body>
</html>




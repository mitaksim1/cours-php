<?php
// Connexion avec PDO
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'mimi', 'Mimi182123*');

// Si problème avec la connexion, cette config va nous retourner un message d'erreur
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Validations
    if (!$title) {
      $errors[] = 'Product title is required';
    }
    if (!$price) {
      $errors[] = 'Product price is required';
    }

    // Création d'un dossier qui va stocker les images
    if (!is_dir('images')) {
      mkdir('images');
    }

    // On n'enregistre les données que s'il n'y a pas des erreurs
    if (empty($errors)) {
      // vérifie s'il existe une image dans la variable globale
      $image = $_FILES['image'] ?? null;
      $imagePath = $product['image'];
      
      // Pour éviter qu'un chemin soit sauvegardé dans la bdd sans qu'une image soit chargée il faut aussi vérifier si la clé tmp_name est rempli
      if ($image && $image['tmp_name']) {

        // Attribue un nom unique aux images
        $imagePath = 'images/' . 'uploads' . '/' . randomString(8) . '-' . $image['name'];
  
        // dirname($imagePath);

        move_uploaded_file($image['tmp_name'], $imagePath);
      }

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

// Génère une chaîne de caractères aléatoires pour donner un nom unique aux images
function randomString($n)
{
  $characters = '0123456789abcdefghijklnopqrstuvxywzABCDEFGHIJKLMNOPQRSTUVXYWZ';
  $str = '';

  for ($i = 0; $i < $n; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $str.= $characters[$index];
  }
  return $str;
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
        <p>
            <a href="index.php" class="btn btn-secondary">Go back to Products</a>
        </p>

        <h1>Update product : <b><?php echo $product['title'] ?></b></h1>

        <!-- Message d'erreur si donnée manquante  -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $error): ?>
                <div><?php echo $error ?></div>
              <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <!-- enctype: permet de charger des fichiers -->
        <form action="" method="post" enctype="multipart/form-data">

            <!-- Image exists -->
            <?php if ($product['image']): ?>
                <img class="update-image" src="<?php echo $product['image'] ?>" alt="">
            <?php endif; ?>

          <div class="form-group mb-3">
            <label>Product Image</label>
            <br>
            <input type="file" name="image">
          </div>
          
          <div class="form-group mb-3">
            <label>Product Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $title ?>">
          </div>
          
          <div class="form-group mb-3">
            <label>Product Description</label>
            <textarea type="text" name="description" class="form-control"><?php echo $description ?></textarea>
          </div>

          <div class="form-group mb-3">
            <label>Product Price</label>
            <input type="number" name="price" step="0.1" class="form-control" value="<?php echo $price ?>">
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>  
  </body>
</html>





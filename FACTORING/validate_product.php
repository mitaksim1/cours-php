<?php

// Récupérations des données retournées par la requête
$title = $product['title'];
$price = $product['price'];
$description = $product['description'];
$imagePath = '';


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
    // La variable globale __DIR__ fait référence au répertoire courant du fichier où on est,
    // ici on est sur le fichier validate_product qui est dans le répertoire FACTORING, alors __DIR__ = FACTORING
    if (!is_dir(__DIR__.'/public/images')) {
        mkdir(__DIR__.'/public/images');
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

            move_uploaded_file($image['tmp_name'], __DIR__ . '/public/' . $imagePath);
        }
    }
} 
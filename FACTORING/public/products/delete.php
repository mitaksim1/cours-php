<?php
require_once "../../database.php";

// On peut comme on peut ne pas récupérer l'id, alors il faut prévoir cette possibilité
$id = $_POST['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// Si l'id existe on pourra passer la requête
$statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();

// Après la requête on redirige l'utilisateur vers la page principale
header('Location: index.php');


// echo '<pre>';
// var_dump($id);
// echo '</pre>';
// exit;
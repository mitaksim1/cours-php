<?php
namespace app\models;

use app\Database;
use app\helpers\UtilHelper;

class Product
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $imagePath = null;
    public ?float $price = null;
    public ?array $imageFile = null;

    public function load($data)
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'];
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'];
        $this->imageFile = $data['imageFile'] ?? null;
        $this->imagePath = $data['image'] ?? null;
    }

    public function save()
    {
        $errors = [];

        if (!$this->title) {
            $errors[] = 'Product title is required';
        }

        if (!$this->price) {
            $errors[] = 'Product price is required';
        }

        // Création d'un dossier qui va stocker les images
        // La variable globale __DIR__ fait référence au répertoire courant du fichier où on est,
        if (!is_dir(__DIR__.'/../../public/images')) {
            mkdir(__DIR__.'/../../public/images');
        }

        // On n'enregistre les données que s'il n'y a pas des erreurs
        if (empty($errors)) {

            // Pour éviter qu'un chemin soit sauvegardé dans la bdd sans qu'une image soit chargée il faut aussi vérifier si la clé tmp_name est rempli
            if ($this->imageFile && $this->imageFile['tmp_name']) {

                // Attribue un nom unique aux images
                $this->imagePath = 'images/' . 'uploads' . '/' . UtilHelper::randomString(8) . '-' . $this->imageFile['name'];

                move_uploaded_file($this->imageFile['tmp_name'], __DIR__ . '/../../public/' . $this->imagePath);
            }
            // Connexion à la bdd
            $db = Database::$db;
            if ($this->id) {
                $db->updateProduct($this);
            } else {
                $db->createProduct($this);
            }
        }
        return $errors;  
    }
}
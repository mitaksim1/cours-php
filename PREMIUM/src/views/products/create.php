<h1>Create new Product</h1>

<!-- FORM -->
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
            <img class="update-image" src="/<?php echo $product['image'] ?>" alt="">
        <?php endif; ?>
      <div class="form-group mb-3">
        <label>Product Image</label>
        <br>
        <input type="file" name="image">
      </div>
      
      <div class="form-group mb-3">
        <label>Product Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo $product['title'] ?>">
      </div>
      
      <div class="form-group mb-3">
        <label>Product Description</label>
        <textarea type="text" name="description" class="form-control"><?php echo $product['description'] ?></textarea>
      </div>
      <div class="form-group mb-3">
        <label>Product Price</label>
        <input type="number" name="price" step="0.1" class="form-control" value="<?php echo $product['price'] ?>">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

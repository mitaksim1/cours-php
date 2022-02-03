<h1>Products List</h1>

<p>
  <a href="create.php" class="btn btn-success">Create Product</a>
</p>

<!-- BARRE DE RECHERCHE -->
<form action="">
  <div class="input-group mb-3">
    <!-- Ici on n'a pas accès à la variable $search, on va la déclarer et récupérer son contenu dans ProductController-->
    <input type="text" class="form-control" placeholder="Search product" name="search" value="<?php echo $search ?>">
    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
  </div>
</form>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Create date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($products as $i => $product): ?>
      <tr>
        <th scope="row"><?php echo $i + 1 ?></th>
        <td>
          <img class="thumb-image" src="/<?php echo $product['image'] ?>" alt="">
        </td>
        <td><?php echo $product['title'] ?></td>
        <td><?php echo $product['price'] ?></td>
        <td><?php echo $product['create_date'] ?></td>
        <td>
          <!-- UPDATE -->
          <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
          <!-- DELETE -->
          <!-- Pour supprimer un produit de la bdd , c'est mieux d'utiliser la méthode POST, alors on change le bouton de <a> à <buuton> -->
          <form style="display: inline-block;" action="delete.php" method="post">
            <!-- On récupère l'id avec un input du type hidden -->
            <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach ?>   
  </tbody>
</table>
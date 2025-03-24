<?php
  session_start();

  require_once "includes/conexion.php";
  require_once "includes/header.php";

  $sql = "SELECT * FROM categorias";
  $query_full_categorias = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body>
  <div id="contenedor">
    <?php require "includes/sidebar.php"; ?>
    <div id="principal">
      <h1 style="text-align: center;">Todas las categorías</h1>
      <div class="full-categorias">
        <?php while ($full_categorias = mysqli_fetch_assoc($query_full_categorias)): ?>
          <article class="entrada">
            <a href="categoria.php?categoria=<?= $full_categorias["id"]; ?>">
              <span>Categoría: </span>
              <?= htmlspecialchars($full_categorias["nombre"]) ?>
            </a>
          </article>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
  <?php include "includes/footer.php"; ?>
</body>
</html>

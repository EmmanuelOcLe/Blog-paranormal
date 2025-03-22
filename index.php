<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  session_start();
  $_SESSION["dasfssgddgsgfvgrdf2352"] = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Inicio</title>
</head>
<body>
  <!-- Header -->
  <?php include 'includes/header.php' ?>

  <!-- Cuerpo -->
  <div id="contenedor">
      <?php include 'includes/sidebar.php' ?>
      
      <div id="principal">
          <h1>Últimas entradas</h1>
          <article class="entrada">
              <a href="entrada.php?id=<?=$entrada['id']?>">
                  <h2>{Titulo Entrada}</h2>
                  <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                  <p>
                      {Descripcion de entrada}
                  </p>
              </a>
          </article>
          
          <article class="entrada">
              <a href="entrada.php?id=<?=$entrada['id']?>">
                  <h2>{Titulo Entrada}</h2>
                  <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                  <p>
                      {Descripcion de entrada}
                  </p>
              </a>
          </article>
          
          <article class="entrada">
              <a href="entrada.php?id=<?=$entrada['id']?>">
                  <h2>{Titulo Entrada}</h2>
                  <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                  <p>
                      {Descripcion de entrada}
                  </p>
              </a>
          </article>
          
          <article class="entrada">
              <a href="entrada.php?id=<?=$entrada['id']?>">
                  <h2>{Titulo Entrada}</h2>
                  <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                  <p>
                      {Descripcion de entrada}
                  </p>
              </a>
          </article>
          
          <article class="entrada">
              <a href="entrada.php?id=<?=$entrada['id']?>">
                  <h2>{Titulo Entrada}</h2>
                  <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                  <p>
                      {Descripcion de entrada}
                  </p>
              </a>
          </article>
          
          <div id="ver-todas">
              <a href="entradas.php">Ver todas las entradas</a>
          </div>
      </div>
      
  </div>

  <!-- Footer -->
  <?php include 'includes/footer.php' ?>
</body>
</html>
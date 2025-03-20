<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>mis datos</title>
</head>
<body>
      <!-- Header -->
      <?php include '/includes/header.php'?>


    <!-- Cuerpo -->
    <div id="contenedor">
      
      <div id="principal">
          <h1>Datos de usuario</h1>
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
</body>
</html>
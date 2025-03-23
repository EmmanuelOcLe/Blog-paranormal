<?php
  session_start();

  require "includes/conexion.php";
  require_once "includes/header.php";

  if (!isset($_GET["categoria"]))
  {
    header("Location: index.php");
    exit();
  }

  $categoria = $_GET["categoria"];

  $sql = "SELECT e.id, e.titulo, u.nombre AS 'nombre_autor',
  c.nombre AS 'categoria', e.fecha AS 'fecha_creacion', SUBSTRING(e.descripcion, 1, 250) AS 'descripcion'
  FROM entradas e
  INNER JOIN categorias c
  ON e.categoria_id = c.id
  INNER JOIN usuarios u
  ON e.usuario_id = u.id
  WHERE e.categoria_id = $categoria";

  $query = mysqli_query($conexion, $sql);

  if (mysqli_num_rows($query) == 0)
  {
    echo "<script>alert('La categoría está vacía')</script>";
    echo "<script>window.location.href = 'index.php'</script>";
    exit();
  }

  $query_nombre = mysqli_query($conexion, "SELECT nombre FROM categorias WHERE id = $categoria");

  $nombre_categoria = mysqli_fetch_assoc($query_nombre);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title><?php echo $nombre_categoria["nombre"]; ?></title>
</head>
<body>
  <div id="contenedor">
    <?php require "includes/sidebar.php"; ?>
    <div id="principal">
      <h1><?php echo $nombre_categoria["nombre"]; ?></h1>
      <?php while ($result = mysqli_fetch_assoc($query)) : ?>
          <article class="entrada">
            <a href="entrada.php?id=<?= $result["id"] ?>">
              <h2 style="width: 80%;"><?= htmlspecialchars($result['titulo']) ?></h2>
            </a>
            <span class="fecha">Categoría: <?= htmlspecialchars($result['categoria']) ?></span>
            <br>
            <span class="fecha">Fecha de creación: <?= htmlspecialchars($result['fecha_creacion']) ?> </span>
            <br>
            <span class="fecha">Autor: <?= htmlspecialchars($result['nombre_autor']) ?></span>
            <p><?= htmlspecialchars($result['descripcion']);?></p>
          </article>
      <?php endwhile; mysqli_close($conexion);?>
      
      <div id="ver-todas">
          <a href="entradas.php">Ver todas las entradas</a>
      </div>
    </div>
  </div>

  <?php require "includes/footer.php"; ?>
</body>
</html>
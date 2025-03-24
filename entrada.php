<?php
    session_start();
    $_SESSION["dasfssgddgsgfvgrdf2352"] = "";
    require_once 'includes/header.php';
    require_once 'includes/conexion.php';

    $entrada_id = $_GET["id"];

    $sql = "SELECT e.titulo, c.nombre AS 'categoria', e.fecha, u.nombre AS 'autor', e.descripcion
    FROM entradas e
    INNER JOIN categorias c
    ON c.id = e.categoria_id
    INNER JOIN usuarios u
    ON u.id = e.usuario_id
    WHERE e.id = $entrada_id";
    $query = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($query) == 0)
    {
      echo "<script>alert('No existe la entrada especificada')</script>";
      echo "<script>window.location.href = 'index.php'</script>";
      exit();
    }

    $entrada = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="contenedor">
    <?php include 'includes/sidebar.php' ?>
    <div id="principal">
        <div class="entrada-top-title">
          <a href="index.php" style="color: #fff">Volver</a>
          <h1 style="margin: 0 auto; text-align: center; color: #2979cd; width: fit-content;"><?= htmlspecialchars($entrada["titulo"]); ?></h1>
        </div>
        <span class="fecha">Categoría: <?= htmlspecialchars($entrada["categoria"]); ?></span>
        <br>
        <span class="fecha">Fecha de creación: <?= $entrada["fecha"]; ?></span>
        <br>
        <span class="fecha">Autor: <?= htmlspecialchars($entrada["autor"]); ?></span>
        <p style="word-wrap: break-word;"><?= htmlspecialchars($entrada["descripcion"]); ?></p>
    </div>
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>

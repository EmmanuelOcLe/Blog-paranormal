<?php
    session_start();
    $_SESSION["dasfssgddgsgfvgrdf2352"] = "";
    require_once 'includes/header.php';
    require_once 'includes/conexion.php';

    // Obtener solo las últimas 5 entradas con categoría
    $entradas_sql = "SELECT e.id, e.titulo, SUBSTRING(e.descripcion,1,250) AS 'descripcion', e.fecha, c.nombre as categoria FROM entradas e INNER JOIN categorias c ON e.categoria_id = c.id ORDER BY e.id DESC LIMIT 5";
    $entradas = mysqli_query($conexion, $entradas_sql);
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
        <h1>Últimas entradas</h1>
        <?php while ($entrada = mysqli_fetch_assoc($entradas)) : ?>
            <article class="entrada">
                <a href="entrada.php?id=<?= $entrada['id'] ?>">
                    <h2 style="width: 80%"><?= htmlspecialchars($entrada['titulo']) ?></h2>
                    <span class="fecha"> <?= htmlspecialchars($entrada['categoria']) ?> | <?= htmlspecialchars($entrada['fecha']) ?> </span>
                    <p>
                        <?= htmlspecialchars($entrada['descripcion']); ?>
                    </p>
                </a>
            </article>
        <?php endwhile; ?>
        
        <div id="ver-todas">
            <a href="entradas.php">Ver todas las entradas</a>
        </div>
    </div>
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>

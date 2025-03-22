<?php
    session_start();
    require_once 'includes/header.php';
    require_once 'includes/conexion.php';

    // Obtener todas las entradas con categoría
    $entradas_sql = "SELECT e.id, e.titulo, e.descripcion, e.fecha, c.nombre as categoria FROM entradas e INNER JOIN categorias c ON e.categoria_id = c.id ORDER BY e.id DESC";
    $entradas = mysqli_query($conexion, $entradas_sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas las Entradas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="contenedor">
    <?php include 'includes/sidebar.php' ?>
    <div id="principal">
        <h1>Todas las Entradas</h1>
        <?php while ($entrada = mysqli_fetch_assoc($entradas)) : ?>
            <article class="entrada">
                <a href="entrada.php?id=<?= $entrada['id'] ?>">
                    <h2><?= htmlspecialchars($entrada['titulo']) ?></h2>
                    <span class="fecha"> <?= htmlspecialchars($entrada['categoria']) ?> | <?= htmlspecialchars($entrada['fecha']) ?> </span>
                    <p>
                        <?= htmlspecialchars(substr($entrada['descripcion'], 0, 200)) ?>...
                    </p>
                </a>
            </article>
        <?php endwhile; ?>
    </div>
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>

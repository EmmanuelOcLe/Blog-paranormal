<?php

    if (!isset($_SESSION["dasfssgddgsgfvgrdf2352"]))
    {
        header("Location: ../index.php");
        exit();
    }

    require_once 'includes/conexion.php'; // Conexión a la base de datos

    // Obtener categorías desde la base de datos
    $sql_categorias = "SELECT *
    FROM categorias c
    LEFT JOIN(
        SELECT categoria_id, count(categoria_id) AS 'total'
        FROM entradas
        GROUP BY categoria_id
        ORDER BY COUNT(categoria_id) DESC)
    AS sub
    ON c.id = sub.categoria_id
    ORDER BY sub.total
    DESC
    LIMIT 4";
    $categorias = mysqli_query($conexion, $sql_categorias);
?>

<header id="cabecera">
    <div id="logo">
        <a href="index.php">
            Blog paranormal
        </a>
    </div>
    <nav id="menu">
        <ul>
            <li>
                <a href="index.php">Inicio</a>
            </li>

            <?php while ($categoria = mysqli_fetch_assoc($categorias)) : ?>
                <li>
                    <a href="categoria.php?categoria=<?= $categoria['id']; ?>">
                        <?= htmlspecialchars($categoria['nombre']); ?>
                    </a>
                </li>
            <?php endwhile; ?>

            <li>
                <a href="full-categorias.php">Todas las categorías</a>
            </li>

            <li>
                <a href="index.php">Sobre mí</a>
            </li>
            <li>
                <a href="index.php">Contacto</a>
            </li>
        </ul>
    </nav>
    
    <div class="clearfix"></div>
</header>

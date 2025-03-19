<?php
require_once 'includes/conexion.php'; // Conexión a la base de datos

// Obtener categorías desde la base de datos
$sql_categorias = "SELECT * FROM categorias ORDER BY id ASC";
$categorias = mysqli_query($conexion, $sql_categorias);
?>

<header id="cabecera">
    <div id="logo">
        <a href="index.php">
            Blog de {Temas}
        </a>
    </div>
    <nav id="menu">
        <ul>
            <li>
                <a href="index.php">Inicio</a>
            </li>

            <?php while ($categoria = mysqli_fetch_assoc($categorias)) : ?>
                <li>
                    <a href="categoria.php?id=<?= $categoria['id']; ?>">
                        <?= htmlspecialchars($categoria['nombre']); ?>
                    </a>
                </li>
            <?php endwhile; ?>

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

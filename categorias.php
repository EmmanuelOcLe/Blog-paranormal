<?php
require_once 'includes/conexion.php';

// Obtener todas las categorías
$sql = "SELECT * FROM categorias ORDER BY id DESC";
$result = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Categorías</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Gestión de Categorías</h1>
    
    <!-- Formulario para agregar una nueva categoría -->
    <form action="procesar_categoria.php" method="POST">
        <label for="nombre_categoria">Nueva Categoría:</label>
        <input type="text" name="nombre_categoria" required>
        <input type="submit" value="Agregar Categoría">
    </form>

    <h2>Lista de Categorías</h2>
    <ul>
        <?php while ($categoria = mysqli_fetch_assoc($result)) : ?>
            <li class = "l_categorias">
                <?php echo htmlspecialchars($categoria['nombre']); ?>
                <a href="editar_categoria.php?id=<?php echo $categoria['id']; ?>">[Editar]</a>
                <a href="eliminar_categoria.php?id=<?php echo $categoria['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar esta categoría?');">[Eliminar]</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

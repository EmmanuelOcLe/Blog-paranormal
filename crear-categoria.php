<?php
session_start();

require_once 'includes/header.php';
require_once 'includes/conexion.php'; 

$mensaje = "";

// Crear o actualizar categoría
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre_categoria'])) {
    $nombre_categoria = trim($_POST['nombre_categoria']);

    if (!empty($nombre_categoria)) {
        if (isset($_POST['id_categoria']) && !empty($_POST['id_categoria'])) {
            // Actualizar categoría existente
            $id_categoria = intval($_POST['id_categoria']);
            $stmt = $conexion->prepare("UPDATE categorias SET nombre=? WHERE id=?");
            $stmt->bind_param("si", $nombre_categoria, $id_categoria);

            if ($stmt->execute()) {
                header("Location: crear-categoria.php"); 
                exit();
            } else {
                $mensaje = "<button class='btn error'>Error al actualizar la categoría</button>";
            }
            $stmt->close();
        } else {
            // Insertar nueva categoría
            $stmt = $conexion->prepare("INSERT INTO categorias (nombre) VALUES (?)");
            $stmt->bind_param("s", $nombre_categoria);

            if ($stmt->execute()) {
                header("Location: crear-categoria.php"); 
                exit();
            } else {
                $mensaje = "<button class='btn error'>Error al crear la categoría</button>";
            }
            $stmt->close();
        }
    } else {
        $mensaje = "<button class='btn error'>El nombre de la categoría no puede estar vacío</button>";
    }
}

// Eliminar categoría
if (isset($_GET['eliminar'])) {
    $id_categoria = intval($_GET['eliminar']);

    // Verificar que la categoría exista antes de eliminar
    $stmt_verificar = $conexion->prepare("SELECT id FROM categorias WHERE id = ?");
    $stmt_verificar->bind_param("i", $id_categoria);
    $stmt_verificar->execute();
    $resultado = $stmt_verificar->get_result();

    if ($resultado->num_rows > 0) {
        $stmt = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id_categoria);
        
        if ($stmt->execute()) {
            header("Location: crear-categoria.php"); 
                exit();
        } else {
            $mensaje = "<button class='btn error'>Error al eliminar la categoría</button>";
        }
        $stmt->close();
    } else {
        $mensaje = "<button class='btn error'>La categoría no existe</button>";
    }
    $stmt_verificar->close();
}

// Obtener categorías actualizadas
$sql_categorias = "SELECT * FROM categorias ORDER BY id DESC";
$categorias = mysqli_query($conexion, $sql_categorias);

// Si se va a editar, obtener datos de la categoría
$categoria_editar = null;
if (isset($_GET['editar'])) {
    $id_categoria = intval($_GET['editar']);

    $stmt = $conexion->prepare("SELECT * FROM categorias WHERE id = ?");
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $categoria_editar = $resultado->fetch_assoc();

    if (!$categoria_editar) {
        $mensaje = "<button class='btn error'>La categoría no existe</button>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/categorias.css">
</head>
<body>
    <div id="contenedor">
        <div id="principal">
            <h1>Gestión de Categorías</h1>

            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="hidden" name="id_categoria" value="<?= $categoria_editar['id'] ?? '' ?>">
                <label for="nombre_categoria">Nombre de la categoría:</label>
                <input type="text" name="nombre_categoria" value="<?= htmlspecialchars($categoria_editar['nombre'] ?? '') ?>" required>
                <button type="submit" class="btn <?= isset($categoria_editar) ? 'edit' : 'success' ?>">
                    <?= isset($categoria_editar) ? 'Actualizar Categoría' : 'Crear Categoría' ?>
                </button>
            </form>

            <h2>Lista de Categorías</h2>
            <ul>
                <?php while ($categoria = mysqli_fetch_assoc($categorias)) : ?>
                    <li>
                        <?= htmlspecialchars($categoria['nombre']); ?>
                        <a href="?editar=<?= $categoria['id']; ?>" class="btn edit">Editar</a>
                        <a href="?eliminar=<?= $categoria['id']; ?>" class="btn delete" onclick="return confirm('¿Seguro que deseas eliminar esta categoría?')">Eliminar</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <?php include 'includes/footer.php' ?>
</body>
</html>

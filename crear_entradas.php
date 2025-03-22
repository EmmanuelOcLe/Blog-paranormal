<?php
    session_start();
    require_once 'includes/header.php';
    require_once 'includes/conexion.php'; 

    $mensaje = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tituloEntrada'])) {
        $tituloEntrada = trim($_POST['tituloEntrada']);
        $descripcionEntrada = trim($_POST['descripcionEntrada']);
        $categoria_id = intval($_POST['categoria_id']);
        $usuario_id = $_SESSION['usuario_id'] ?? 1; // esto es suponiendo que el usuario ya esta logueado
        date_default_timezone_set("America/Bogota");
        $fecha = date("Y-m-d");
    
        if (!empty($tituloEntrada) && !empty($descripcionEntrada) && !empty($categoria_id) && !empty($fecha)) {
            if (isset($_POST['id_entrada']) && !empty($_POST['id_entrada'])) {
                // Actualizar entrada existente
                $id_entrada = intval($_POST['id_entrada']);
                $stmt = $conexion->prepare("UPDATE entradas SET titulo=?, descripcion=?, categoria_id=?, fecha=? WHERE id=?");
                $stmt->bind_param("ssisi", $tituloEntrada, $descripcionEntrada, $categoria_id, $fecha, $id_entrada);
    
                if ($stmt->execute()) {
                    $mensaje = "<button class='btn success'>Entrada actualizada exitosamente</button>";
                } else {
                    $mensaje = "<button class='btn error'>Error al actualizar la entrada</button>";
                }
                $stmt->close();
            } else {
                // Insertar nueva entrada
                $stmt = $conexion->prepare("INSERT INTO entradas (usuario_id, categoria_id, titulo, descripcion, fecha) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("iisss", $usuario_id, $categoria_id, $tituloEntrada, $descripcionEntrada, $fecha);
    
                if ($stmt->execute()) {
                    $mensaje = "<button class='btn success'>Entrada creada exitosamente</button>";
                } else {
                    $mensaje = "<button class='btn error'>Error al crear la entrada</button>";
                }
                $stmt->close();
            }
        } else {
            $mensaje = "<button class='btn error'>Todos los campos son obligatorios</button>";
        }
    }
    
    // Eliminar entrada
    if (isset($_GET['eliminar'])) {
        $id_entrada = intval($_GET['eliminar']);
    
        $stmt_verificar = $conexion->prepare("SELECT id FROM entradas WHERE id = ?");
        $stmt_verificar->bind_param("i", $id_entrada);
        $stmt_verificar->execute();
        $resultado = $stmt_verificar->get_result();
    
        if ($resultado->num_rows > 0) {
            $stmt = $conexion->prepare("DELETE FROM entradas WHERE id = ?");
            $stmt->bind_param("i", $id_entrada);
            
            if ($stmt->execute()) {
                $mensaje = "<button class='btn success'>Entrada eliminada correctamente</button>";
            } else {
                $mensaje = "<button class='btn error'>Error al eliminar la entrada</button>";
            }
            $stmt->close();
        } else {
            $mensaje = "<button class='btn error'>La entrada no existe</button>";
        }
        $stmt_verificar->close();
    }
    
    // Obtener entradas actualizadas con categoría
    $entradas_sql = "SELECT e.id, e.titulo, e.descripcion, e.fecha, c.nombre as categoria FROM entradas e INNER JOIN categorias c ON e.categoria_id = c.id ORDER BY e.id DESC";
    $entradas = mysqli_query($conexion, $entradas_sql);
    
    // Obtener categorias para el formulario
    $categorias_sql = "SELECT id, nombre FROM categorias";
    $categorias = mysqli_query($conexion, $categorias_sql);
    
    // Si se va a editar obtener datos de la entrada
    $editarEntrada = null;
    if (isset($_GET['editar'])) {
        $id_entrada = intval($_GET['editar']);
    
        $stmt = $conexion->prepare("SELECT * FROM entradas WHERE id = ?");
        $stmt->bind_param("i", $id_entrada);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $editarEntrada = $resultado->fetch_assoc();
    
        if (!$editarEntrada) {
            $mensaje = "<button class='btn error'>La entrada no existe</button>";
        }
    
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear entradas</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/categorias.css">
</head>
<body>
<div id="contenedor">
    <div id="principal">
        <h1>Gestión de Entradas</h1>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" name="id_entrada" value="<?= $editarEntrada['id'] ?? '' ?>">
            <label for="tituloEntrada">Título:</label>
            <input type="text" name="tituloEntrada" value="<?= htmlspecialchars($editarEntrada['titulo'] ?? '') ?>" required>
            <label for="descripcionEntrada">Descripción:</label>
            <textarea name="descripcionEntrada" value="<?= htmlspecialchars($editarEntrada['descripcion'] ?? '') ?>" required></textarea>
            <label for="categoria_id">Categoría:</label>
            <select name="categoria_id" required>
                <?php while ($categoria = mysqli_fetch_assoc($categorias)) : ?>
                    <option value="<?= $categoria['id'] ?>" <?= isset($editarEntrada) && $editarEntrada['categoria_id'] == $categoria['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categoria['nombre']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn <?= isset($editarEntrada) ? 'edit' : 'success' ?>">
                <?= isset($editarEntrada) ? 'Actualizar entrada' : 'Crear entrada' ?>
            </button>
        </form>
        <h2>Lista de Entradas</h2>
        <ul>
            <?php while ($entrada = mysqli_fetch_assoc($entradas)) : ?>
                <li>
                    <?= htmlspecialchars($entrada['titulo']) ?> - <strong><?= htmlspecialchars($entrada['categoria']) ?></strong>
                    <a href="?editar=<?= $entrada['id'] ?>" class="btn edit">Editar</a>
                    <a href="?eliminar=<?= $entrada['id'] ?>" class="btn delete" onclick="return confirm('¿Seguro que deseas eliminar esta entrada?')">Eliminar</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>

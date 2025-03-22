<?php 
session_start();
require_once 'includes/conexion.php';
require_once 'includes/header.php';

// Si ingresan directamente, se redirecciona al index
if (!isset($_SESSION["dasfssgddgsgfvgrdf2352"])) {
    header("Location: index.php");
    exit();
}

$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$entradas = [];

if (!empty($busqueda)) {
    $param = "%$busqueda%";

    // Buscar ID de la categoría
    $sql_categoria = "SELECT id FROM categorias WHERE nombre LIKE ? LIMIT 1";
    $stmt_categoria = $conexion->prepare($sql_categoria);
    $stmt_categoria->bind_param("s", $param);
    $stmt_categoria->execute();
    $resultado_categoria = $stmt_categoria->get_result();

    $categoria_id = null;
    if ($resultado_categoria->num_rows > 0) {
        $categoria = $resultado_categoria->fetch_assoc();
        $categoria_id = $categoria['id'];
    }
    $stmt_categoria->close();

    // Consulta principal para buscar en títulos, descripciones y categorías
    $sql = "SELECT e.id, e.titulo, e.descripcion, e.fecha, c.nombre AS categoria 
            FROM entradas e 
            JOIN categorias c ON e.categoria_id = c.id 
            WHERE e.titulo LIKE ? OR e.descripcion LIKE ?";
    
    // Si hay una categoría encontrada, se agrega a la consulta
    if ($categoria_id !== null) {
        $sql .= " OR e.categoria_id = ?";
    }

    $stmt = $conexion->prepare($sql);
    if ($categoria_id !== null) {
        $stmt->bind_param("ssi", $param, $param, $categoria_id);
    } else {
        $stmt->bind_param("ss", $param, $param);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();

    while ($fila = $resultado->fetch_assoc()) {
        $entradas[] = $fila;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/buscar.css">
</head>
<body>
    <div id="contenedor">
        <?php include 'includes/sidebar.php'; ?>
        
        <div id="busqueda-contenedor">
            <h1>Resultados de la Búsqueda</h1>
            <?php if (!empty($entradas)): ?>
                <ul id="busqueda-resultados">
                    <?php foreach ($entradas as $entrada): ?>
                        <li class="busqueda-item">
                            <a href="entrada.php?id=<?= $entrada['id'] ?>">
                                <strong><?= htmlspecialchars($entrada['titulo']); ?></strong>: 
                                <?= htmlspecialchars($entrada['descripcion']); ?> 
                                <span class="busqueda-categoria">(Categoría: <?= htmlspecialchars($entrada['categoria']); ?>)</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="busqueda-alerta-error">No se encontraron resultados.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>

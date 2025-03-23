<?php
session_start();

// Verificando que haya un usuario con sesión iniciada
if (!isset($_SESSION["user_email"]))
{
    header("Location: index.php");
}

require_once 'includes/header.php';
require_once 'includes/conexion.php'; 

$mensaje = "";

// Crear o actualizar categoría
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre_categoria'])) {
    $nombre_categoria = trim($_POST['nombre_categoria']);

    if (!empty($nombre_categoria)) {
        if (strlen($nombre_categoria) > 15) {
            $mensaje = "<button class='btn error'>El nombre de la categoría no puede superar los 15 caracteres</button>";
        } else {
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
        }
    } else {
        $mensaje = "<button class='btn error'>El nombre de la categoría no puede estar vacío</button>";
    }
}

// Eliminar categoría y sus entradas asociadas
if (isset($_GET['eliminar'])) {
    $id_categoria = intval($_GET['eliminar']);

    $sql2 = "SELECT usuario_id FROM entradas WHERE categoria_id = $id_categoria";
    $query2 = mysqli_query($conexion, $sql2);
    $id_autor = mysqli_fetch_assoc($query2);

    if ($_SESSION["user_id"] == $id_autor["usuario_id"])
    {
        // Verificar que la categoría existe
        $stmt_verificar = $conexion->prepare("SELECT id FROM categorias WHERE id = ?");
        $stmt_verificar->bind_param("i", $id_categoria);
        $stmt_verificar->execute();
        $resultado = $stmt_verificar->get_result();
    
        if ($resultado->num_rows > 0) {
            // Primero eliminamos las entradas asociadas
            $stmt1 = $conexion->prepare("DELETE FROM entradas WHERE categoria_id = ?");
            $stmt1->bind_param("i", $id_categoria);
            $stmt1->execute();
            $stmt1->close();
    
            // Luego eliminamos la categoría
            $stmt2 = $conexion->prepare("DELETE FROM categorias WHERE id = ?");
            $stmt2->bind_param("i", $id_categoria);
    
            if ($stmt2->execute()) {
                header("Location: crear-categoria.php"); 
                exit();
            } else {
                $mensaje = "<button class='btn error'>Error al eliminar la categoría</button>";
            }
            $stmt2->close();
        } else {
            $mensaje = "<button class='btn error'>La categoría no existe</button>";
        }
        $stmt_verificar->close();
    }
    else
    {
        echo "<script>alert('No puede eliminar una categoría que no creó.')</script>";
        echo "<script>window.location.href = 'crear-categoria.php'</script>";
        exit();
    }

}

// Obtener categorías actualizadas
$sql_categorias = "SELECT * FROM categorias ORDER BY id DESC";
$categorias = mysqli_query($conexion, $sql_categorias);

// Si se va a editar, obtener datos de la categoría
$categoria_editar = null;
if (isset($_GET['editar'])) {
    $id_categoria = intval($_GET['editar']);

    $sql2 = "SELECT usuario_id FROM entradas WHERE categoria_id = $id_categoria";
    $query2 = mysqli_query($conexion, $sql2);
    $id_autor = mysqli_fetch_assoc($query2);

    if ($_SESSION["user_id"] == $id_autor["usuario_id"])
    {
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
    else
    {
        echo "<script>alert('No puede editar una categoría que no creó.')</script>";
        echo "<script>window.location.href = 'crear-categoria.php'</script>";
        exit();
    }

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
    <script>
        function validarFormulario(event) {
            let inputNombre = document.getElementById("nombre_categoria");
            if (inputNombre.value.length > 15) {
                alert("El nombre de la categoría no puede superar los 15 caracteres");
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div id="contenedor">
        <?php include 'includes/sidebar.php' ?>
        <div id="principal">
            <h1>Gestión de Categorías</h1>
            <?= $mensaje ?>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="validarFormulario(event)">
                <input type="hidden" name="id_categoria" value="<?= $categoria_editar['id'] ?? '' ?>">
                <label for="nombre_categoria">Nombre de la categoría:</label>
                <input type="text" id="nombre_categoria" name="nombre_categoria" value="<?= htmlspecialchars($categoria_editar['nombre'] ?? '') ?>" required>
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
                        <a href="#" class="btn delete" onclick="confirmarEliminacion(<?= $categoria['id']; ?>)">Eliminar</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <?php include 'includes/footer.php' ?>

    <script>
        function confirmarEliminacion(id_categoria) {
            let confirmacion = confirm("⚠️ ADVERTENCIA: Se eliminarán todas las entradas asociadas a esta categoría. ¿Deseas continuar?");
            if (confirmacion) {
                window.location.href = "crear-categoria.php?eliminar=" + id_categoria;
            }
        }
    </script>
</body>
</html>

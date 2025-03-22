<?php
session_start();
require 'includes/conexion.php';

if (!isset($_SESSION["user_id"])) {
    die("Acceso denegado. Debes iniciar sesión.");
}

$id_usuario = $_SESSION["user_id"];

// Obtener los datos actuales del usuario
$sql = "SELECT nombre, apellidos, email FROM usuarios WHERE id = $id_usuario";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
} else {
    die("No se encontraron datos del usuario.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Datos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/modificar.css">
</head>
<body>

    <!--header-->
    <?php include 'includes/header.php' ?>

    <!--Cuerpo-->
    <div id="contenedor">
      <div id="principal">
      <h1>Modificar Datos</h1>
    
        <form action="modificacion.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

            <label for="password">Nueva Contraseña (dejar en blanco si no deseas cambiarla):</label>
            <input type="password" name="password" id="password">

            <button type="submit">Guardar Cambios</button>
        </form>
    
        <button onclick="window.location.href='mis_datos.php'" class="volver">Volver</button>
      </div>
  </div>

   <!-- Footer -->
   <?php include 'includes/footer.php' ?>
</body>
</html>

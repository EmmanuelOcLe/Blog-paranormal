<?php
session_start();
require 'includes/conexion.php';

if (!isset($_SESSION["user_id"])) {
    die("Acceso denegado.");
}

$id_usuario = $_SESSION["user_id"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$email = $_POST["email"];
$password = $_POST["password"];


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Correo electrónico no válido.");
}


if (!empty($password)) {
    $password_hash = md5($password);
    $sql = "UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', email='$email', password='$password_hash' WHERE id=$id_usuario";
} else {
    $sql = "UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', email='$email' WHERE id=$id_usuario";
}

if ($conexion->query($sql) === TRUE) {
    echo "Datos actualizados correctamente.";
    header("Location: mis_datos.php");
} else {
    echo "Error al actualizar: " . $conexion->error;
}
?>

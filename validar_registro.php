<?php

  require 'includes/conexion.php';

  // Validar que se hayan enviado los datos de usuario desde un formulario. Se hace para que en caso de que el usuario ingrese 
  // A esta página por medio de la url y no desde el formulario, lo redireccione a la página principal
  if ($_SERVER["REQUEST_METHOD"] != "POST")
  {
    header("Location: index.php");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  { 
    $nombre = mysqli_real_escape_string($conexion, $_POST["nombre"]);
    $apellidos = mysqli_real_escape_string($conexion, $_POST["apellidos"]);
    $email = mysqli_real_escape_string($conexion, $_POST["email"]);
    $contrasena = mysqli_real_escape_string($conexion, md5($_POST["password"]));
    
    // Verificar que no exista el mismo usuario para que no se duplique en la DB
    $sql = "SELECT * from usuarios WHERE email = '$email'";
    $query = mysqli_query($conexion, $sql);

    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $location = "index.php";
      $argumento_get = "register_state";
      $id_form = "formulario_registro";
      if (mysqli_num_rows($query) > 0)
      {
        header("Location: $location?$argumento_get=0#$id_form");
      }
      else
      {
        date_default_timezone_set("America/Bogota");
        $fecha = date("Y-m-d");
    
        $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, fecha) VALUES ('$nombre', '$apellidos', '$email', '$contrasena', '$fecha')";
    
        $result = mysqli_query($conexion, $sql);
  
        /* Se redireccion al index con la variable 'register_state' teniendo 2 posibles estados:
        1 = Se registró correctamente
        2 = Email inválido
        0 = Ocurrió un error al registrarse
        */
  
        // El id en la url es para que no tenga que scrollear hasta el formulario y ver si se pudo registrar
        header("Location: $location?$argumento_get=1#$id_form"); 
      }
    }
    else
    {
      header("Location $location?$argumento_get=2#$id_form");
    }
  }
?>
<?php
  require 'includes/conexion.php';

  if ($_SERVER["REQUEST_METHOD"] != "POST")
  {
    header("Location: index.php");
    exit();
  }
  else
  {
    $email = $_POST["email"];
    $contrasena = md5($_POST["password"]);

    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {

      $sql = "SELECT id, email, nombre FROM usuarios WHERE email = '$email' AND password = '$contrasena'";
  
      $query = mysqli_query($conexion, $sql); // Devuelve un objeto mysqli. Si la consulta no arroja nada o genera error, devuelve false
  
      $location = "index.php";
      $login_status = "login_status";
      $id_login = "login";
  
      // Si ocurrió un error en la consulta
      if (!$query)
      {
        echo "Error en la consulta: " . mysqli_error( $conexion );
        header("Location: $location?$login_status=3#$id_login");
        exit();
      }
      else if (mysqli_num_rows($query) == 0)
      {
        header("Location: $location?$login_status=0#$id_login");
      }
      else
      {
        $result = mysqli_fetch_array($query);
        session_start();
        session_unset();
        session_regenerate_id(true); // Para que no se pueda cometer secuestro de sesión
  
        $_SESSION["user_id"] = $id;
        $_SESSION["user_email"] = $email;
        $_SESSION["user_name"] = $result["nombre"];
  
        header("Location: $location");
      }

    }
    else
    {
      header("Location: index.php?login_status=2#login");
    }
  }
?>
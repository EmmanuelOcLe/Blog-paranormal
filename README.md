# 🎯 Blog paranormal

Proyecto realizado con el fin de reforzar conocimientos en el lenguaje de programación PHP, donde se practican temas como sesiones, conexiones a bases de datos SQL, entre otros.

## 🚀 Instalación
1. Clona el repositorio: `git clone https://github.com/usuario/proyecto.git` o descarga el archivo .zip
2. Mueve el proyecto a la carpeta de tu servidor local (Xampp, Wampp, etc)
3. Importa la base de datos que está en los archivos del proyecto y crear un archivo llamado "conexion.php" con código como el dado a contnuación:
   ```php
   <?php

    $host = ""; // Host de tu base de datos
    $user = ""; // Usuario de tu base de datos
    $password = ""; // Contraseña de tu base de datos. Si no tienes, deja el campo vacío
    $db_name = ""; // Nombre de tu base de datos
  
    $conexion = mysqli_connect($host, $user, $password, $db_name);
  
    if (mysqli_connect_errno())
    {
      echo "No se pudo conectar a la base de datos." . mysqli_connect_error();
      exit();
    }
  
    ?>
   ``` 

## 🧩 Uso
1. Abre Xampp, Wampp o el servidor local de tu preferencia.
2. Ve al navegador y busca `localhost/nombre-carpeta-proyecto`

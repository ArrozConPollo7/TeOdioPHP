<?php
// Archivo: login.php

// Obtener los datos del formulario
$documento = isset($_POST['documento']) ? $_POST['documento'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Verificar si se enviaron los datos del formulario
if ($documento !== '' && $password !== '') {
  // Establecer la conexión con la base de datos
  $host = 'localhost';
  $dbname = 'spring_db';
  $username = 'root';
  $password_db = '';

  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para verificar el inicio de sesión
    $query = "SELECT * FROM inquilinos WHERE documento = :documento AND password = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':documento', $documento);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // Verificar si se encontró un resultado
    if ($stmt->rowCount() > 0) {
      // Inicio de sesión exitoso, redirigir al usuario a "Inquilinos.html"
      header('Location: inquilinos.html');
      exit;
    } else {
      // Inicio de sesión fallido, mostrar un mensaje de error
      echo '<script>alert("Inicio de sesión fallido. Verifica tus credenciales.");</script>';
    }
  } catch(PDOException $e) {
    // Error en la conexión o consulta SQL
    echo "Error: " . $e->getMessage();
  }

  // Cerrar la conexión a la base de datos
  $conn = null;
} else {
  echo "Los datos de inicio de sesión no se enviaron correctamente.";
  }
?>

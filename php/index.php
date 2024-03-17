<?php
$mysqli = new mysqli($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], $_ENV['MYSQL_DATABASE']);

if ($mysqli->connect_error) {
    die('Error de Conexión (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

// Procesar el formulario si se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];

    // Preparar la consulta para insertar el nuevo usuario
    $query = "INSERT INTO usuarios (nombre, email) VALUES ('$nombre', '$email')";
    
    // Ejecutar la consulta
    if ($mysqli->query($query) === TRUE) {
        echo "Nuevo usuario agregado correctamente.";
    } else {
        echo "Error al agregar el usuario: " . $mysqli->error;
    }
}

// Consulta para recuperar todos los usuarios
$query_select_users = "SELECT id, nombre, email FROM usuarios";
$result = $mysqli->query($query_select_users);

echo "<h2>Lista de Usuarios</h2>";

if ($result->num_rows > 0) {
    echo "<table border='1'>
          <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron usuarios";
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
</head>
<body>
    <h2>Agregar Usuario</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        
        <input type="submit" value="Agregar Usuario">
    </form>
</body>
</html>

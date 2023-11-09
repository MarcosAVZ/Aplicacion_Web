<?php
session_start();
include '../conexion.php'; // Reemplaza 'conexion.php' con el archivo de conexión a tu base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    // Obtener el ID de usuario de la sesión
    $userId = $_SESSION['user_id'];

    // Realizar una consulta para obtener la contraseña actual del usuario
    $conn = conectar(); // Asegúrate de tener una función de conexión válida
    $sql = "SELECT password FROM padre WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Verificar si la contraseña actual proporcionada coincide con la contraseña almacenada
        if ($currentPassword == $storedPassword) {
            // Actualizar la contraseña en la base de datos
            $updateSql = "UPDATE padre SET password = '$newPassword' WHERE id = $userId";
            if ($conn->query($updateSql)) {
                echo "Contraseña actualizada con éxito.";
            } else {
                echo "Error al actualizar la contraseña: " . $conn->error;
            }
        } else {
            echo "La contraseña actual no es válida.";
        }
    } else {
        echo "Error al obtener la contraseña actual: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Agrega tus etiquetas de encabezado aquí -->
</head>
<body>
    <!-- Formulario para cambiar la contraseña -->
    <form method="POST">
        <label for="current_password">Contraseña Actual:</label>
        <input type="password" name="current_password" required><br>

        <label for="new_password">Nueva Contraseña:</label>
        <input type="password" name="new_password" required><br>

        <input type="submit" value="Cambiar Contraseña">
    </form>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Cuotas Mensuales</title>
</head>
<body>
    <a href="../padre.php">Volver</a>
    <h1>Cuotas Mensuales</h1>
    <form method="post">
        <label for="estado">Filtrar por estado:</label>
        <select name="estado" id="estado">
            <option value="">Todos</option>
            <option value="pendiente">Pendiente</option>
            <option value="pagado">Pagado</option>
        </select>
        <input type="submit" value="Filtrar">
    </form>
<?php
session_start();
    // Supongamos que $id_padre contiene el ID del padre actual
    require '../../conexion.php';

    $conexion = conectar();
    if (isset($_SESSION['user_id'])) {
        $id_adre = $_SESSION['user_id'];

    // Verifica la conexión
    if (!$conexion) {
        die("La conexión a la base de datos falló: " . mysqli_connect_error());
    }

    // Inicializa la variable de estado
    $estado_seleccionado = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["estado"])) {
        // Obtiene el estado seleccionado desde el formulario
        $estado_seleccionado = $_POST["estado"];
    }

    // Consulta SQL para obtener las cuotas del padre actual
    $sql = "SELECT mes, año, monto, estado FROM cuotas WHERE id_padre = $id_padre";

    // Agrega una cláusula WHERE solo si se ha seleccionado un estado
    if (!empty($estado_seleccionado)) {
        $sql .= " AND estado = '$estado_seleccionado'";
    }

    $resultado = mysqli_query($conexion, $sql);

    } else {
    // Si no se ha iniciado sesión, puedes redirigir al usuario a la página de inicio de sesión
    header('Location: padre.php');
    exit();
    }
    if (mysqli_num_rows($resultado) > 0) {
        // Muestra los resultados en una tabla
        echo "<table>
                <tr>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Monto</th>
                    <th>Estado</th>
                </tr>";

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                    <td>" . $fila["mes"] . "</td>
                    <td>" . $fila["año"] . "</td>
                    <td>$" . $fila["monto"] . "</td>
                    <td>" . $fila["estado"] . "</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron cuotas mensuales para este padre.";
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
?>

</body>
</html>

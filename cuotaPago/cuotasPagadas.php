<!DOCTYPE html>
<html>
<head>
    <title>Cuotas Pagadas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        a.button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <a class="button" href="intermedioCuotas.php">Volver</a>
    <h1>Cuotas Pagadas</h1>
    <?php
    // Conexión a la base de datos (reemplaza con tus datos de conexión)
    require '../../conexion.php';
    $conn = conectar();

    // ID del padre (reemplaza 1 con el ID del padre deseado)
    $padreId = 1;

    // Consulta SQL para seleccionar las cuotas en estado "pagado" relacionadas con el padre
    $query = "SELECT cuotas.monto, cuotas.mes
              FROM cuotas
              WHERE cuotas.id_padre = $padreId
              AND cuotas.estado = 'pagado'";

    $result = mysqli_query($conn, $query);

    // Verifica si se obtuvieron resultados
    if ($result && mysqli_num_rows($result) > 0) {
        // Comienza a imprimir la tabla
        echo '<table>';
        echo '<tr>';
        echo '<th>Monto de la Cuota</th>';
        echo '<th>Mes de la Cuota</th>';
        echo '</tr>';

        // Recorre los resultados y agrega filas a la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>$' . $row['monto'] . '</td>';
            echo '<td>' . $row['mes'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "<p>No se encontraron cuotas pagadas para este padre.</p>";
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
    ?>
</body>
</html>

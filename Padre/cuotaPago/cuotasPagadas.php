<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Css/styles.css">
    <title>Cuotas Pagadas</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Cuotas Pagadas</h1>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <img src="../../Css/Logotipo200x200.png" class="rounded mx-auto d-block">
            </div>
            <div class="list-group">
            <?php
            session_start();
                if (isset($_SESSION['autoridad']) && $_SESSION['autoridad'] == 1) {
                ?>
                <a href="../../Autoridad/autoridad.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
                <?php  
                }else{
                ?>
                <a href="../padre.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
                <?php 
                }
            ?>
                <a href="../horarioHijo.php" class="list-group-item list-group-item-action">Horarios</a>
                <a href="../boletinHijo.php" class="list-group-item list-group-item-action">Boletín</a>
                <a class="dropdown-toggle list-group-item list-group-item-action active" aria-current="true" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cuotasPagadas.php">Cuotas Pagadas</a></li>
                    <li><a class="dropdown-item" href="pagar_cuota.php">Cuotas Pendientes</a></li>
                </ul>
            </div>
        </div>
        <a href="..\..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
    </div>
    <!-- Termina el bloque de código del sidebar -->
    
    <div class="mt-2 mx-auto p-2" style="width: 90vw">
        <?php
        // Conexión a la base de datos (reemplaza con tus datos de conexión)
        require '../../conexion.php';
        $conn = conectar();

        // ID del padre (reemplaza 1 con el ID del padre deseado)
        if (isset($_SESSION['user_id'])) {
            $padreId = $_SESSION['user_id'];

        // Consulta SQL para seleccionar las cuotas en estado "pagado" relacionadas con el padre
        $query = "SELECT cuotas.monto, cuotas.mes
              FROM cuotas
              WHERE cuotas.id_padre = $padreId
              AND cuotas.estado = 'pagado'";

        $result = mysqli_query($conn, $query);
        } else {
        // Si no se ha iniciado sesión, puedes redirigir al usuario a la página de inicio de sesión
        header('Location: padre.php');
        exit();
        }
        // Verifica si se obtuvieron resultados
        if ($result && mysqli_num_rows($result) > 0) {
            // Comienza a imprimir la tabla
            echo '<table class="table table-striped table-bordered">';
            echo '<tr class="table-info">';
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
        <!-- Botón para imprimir tabla -->
    </div>
    <a class="no-print ms-3" type='button' onclick='imprimirTabla()'><img src='../../Css/print.png' width='50px'></a>
    <div id="footer">
        <img src="../../Css/Logotipo200x200.png">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- Script para imprimir la tabla -->
<script>
    function imprimirTabla() {
        window.print();
    }
</script>

</html>
<!DOCTYPE html>
<html>

<head>
    <title>Proceso Pago</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Css/styles.css">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .form-row label {
            text-align: left;
            flex-basis: 30%;
            margin-right: 10px;
        }

        .form-row input {
            flex-basis: 70%;
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Proceso Pago</h1>
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
                <a href="../padre.php" class="list-group-item list-group-item-action">Página Principal</a>
                <a href="../horarioHijo.php" class="list-group-item list-group-item-action">Horarios</a>
                <a href="../boletinHijo.php" class="list-group-item list-group-item-action">Boletín</a>
                <a href="../PassPadre.php" class="list-group-item list-group-item-action">Cambiar Contraseña</a>
                <a class="dropdown-toggle list-group-item list-group-item-action active" aria-current="true" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cuotasPagadas.php">Cuotas Pagadas</a></li>
                    <li><a class="dropdown-item" href="pagar_cuota.php">Cuotas Pendientes</a></li>
                </ul>
            </div>
            <a href="../../index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->
    <?php
    // Conexión a la base de datos
    require '../../conexion.php';
    $conn = conectar();

    // Obtener los meses pendientes de cuotas relacionadas al ID del padre
    $idPadre = 1;
    $query = "SELECT DISTINCT cuotas.mes
          FROM cuotas
          WHERE cuotas.id_Padre = $idPadre
            AND cuotas.estado = 'pendiente'";
    $result = mysqli_query($conn, $query);
    ?>

    <div class="card form-container mx-auto p-2 mt-3 card-width">
        <form action="procesar_pago.php" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <label class="h6">Monto Pago:</label>
                <input class="form-control max-width-input" type="number" name="montoPago"><br>
            </div>
            <div class="form-row">
                <label class="h6">Mes:</label>
                <select class="form-select max-width-input" name="mesSeleccionado">
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='{$row['mes']}'>{$row['mes']}</option>";
                    }
                    ?>
                </select><br>
            </div>
            <div class="form-row">
                <label class="h6">Nro Comprobante:</label>
                <input class="form-control max-width-input" type="text" name="nroComprobante"><br>
            </div>
            <div class="form-row">
                <label class="h6">Comprobante:</label>
                <input class="form-control max-width-input" type="file" name="comprobante"><br>
            </div>
            <div class="form-row">
                <label class="h6">Método de Pago:</label>
                <select class="form-select max-width-input me-3" name="metodoPago">
                    <option value="Efectivo">Efectivo</option>
                    <option value="Crédito">Crédito</option>
                    <option value="Débito">Débito</option>
                </select>
            </div>
            <br>

            <input class="btn btn-primary" type="submit" value="Guardar">
        </form>
    </div>

    <?php

    // Verifica la conexión
    if (!$conn) {
        die("La conexión a la base de datos falló: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupera los valores del formulario
        $montoPago = $_POST["montoPago"];
        $mesSeleccionado = $_POST["mesSeleccionado"];
        $nroComprobante = $_POST["nroComprobante"];
        $metodoPago = $_POST["metodoPago"]; // Agregamos esta línea para obtener el método de pago

        // Subir el archivo del comprobante
        $comprobanteDir = '../../Comprobantes/'; // Establece la ruta deseada
        $comprobanteNombre = $_FILES['comprobante']['name'];
        $comprobanteTemp = $_FILES['comprobante']['tmp_name'];
        $comprobantePath = $comprobanteDir . $comprobanteNombre;

        if (move_uploaded_file($comprobanteTemp, $comprobantePath)) {
            // Consulta para insertar en la tabla pago
            $query = "INSERT INTO pago (montoPago, fecha, idCuota, nroComprobante, comprobante, metodo) VALUES (?, NOW(), (SELECT id FROM cuotas WHERE mes = ? AND id_Padre = ?), ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            if (isset($_SESSION['user_id'])) {
            $padreId = $_SESSION['user_id'];
            } else {
            // Si no se ha iniciado sesión, puedes redirigir al usuario a la página de inicio de sesión
            header('Location: ../padre.php');
            exit();
             }
            // Vincula los parámetros
            mysqli_stmt_bind_param($stmt, "ssisss", $montoPago, $mesSeleccionado, $idPadre, $nroComprobante, $comprobanteNombre, $metodoPago); // Agregamos $metodoPago

            // Ejecuta la consulta
            if (mysqli_stmt_execute($stmt)) {
                echo "
                <div class=\"alert-success mx-auto\" style=\"width: 500px\">
                <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                Pago registrado con éxito.
              </div>";
            } else {
                echo "
                <div class=\"alert mx-auto\" style=\"width: 500px\">
                <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                Error al registrar el pago: " . mysqli_error($conn);
                echo "</div>";
            }

            // Cierra la declaración
            mysqli_stmt_close($stmt);
        } else {
            echo "
                <div class=\"alert mx-auto card-width\" >
                <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                Error al subir el archivo del comprobante.
              </div>";
        }
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
    ?>
    <div id="footer">
        <img src="../../Css/Logotipo200x200.png">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>
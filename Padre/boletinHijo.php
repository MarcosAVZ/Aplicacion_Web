<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Boletín</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Boletín</h1>
    </header>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Secciones</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <img src="../Css/Logotipo200x200.png" class="rounded mx-auto d-block">
            </div>
            <div class="list-group">
            <?php
             session_start();
                if (isset($_SESSION['autoridad']) && $_SESSION['autoridad'] == 1) {
                ?>
                <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
                <?php  
                }else{
                ?>
                <a href="padre.php" class="list-group-item list-group-item-action active" aria-current="true">Página Principal</a>
                <?php 
                }
            ?>
                <a href="horarioHijo.php" class="list-group-item list-group-item-action">Horarios</a>
                <a href="boletinHijo.php" class="list-group-item list-group-item-action active" aria-current="true">Boletín</a>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cuotaPago/cuotasPagadas.php">Cuotas Pagadas</a></li>
                    <li><a class="dropdown-item" href="cuotaPago/pagar_cuota.php">Cuotas Pendientes</a></li>
                </ul>
            </div>
            <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->

    <div class="mx-auto p-2" style="width: 90vw">
        <?php
        // Conexión a la base de datos
        require '../conexion.php';

        $conn = conectar();


        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error en la conexión: " . $conn->connect_error);
        }

        // Consulta para obtener los alumnos vinculados al padre
        if (isset($_SESSION['user_id'])) {
            $idPadre = $_SESSION['user_id'];
        $sql = "SELECT alumno.nombre AS nombre_alumno, curso.nombre AS nombre_curso, examen.nombre AS nombre_examen, examenalumno.nota
        FROM alumno
        INNER JOIN alumnocurso ON alumno.id = alumnocurso.idAlumno
        INNER JOIN examen ON alumnocurso.idCurso = examen.idCurso
        INNER JOIN examenalumno ON alumno.id = examenalumno.idAlumno AND examen.id = examenalumno.idExamen
        INNER JOIN curso ON examen.idCurso = curso.id
        WHERE alumno.idPadre = $idPadre";

        $result = $conn->query($sql);
        } else {
        // Si no se ha iniciado sesión, puedes redirigir al usuario a la página de inicio de sesión
        header('Location: padre.php');
        exit();
        }
        // Verificar si se encontraron resultados
        if ($result->num_rows > 0) {
            // Mostrar la tabla con los datos de los alumnos y sus notas
            echo "<table class=\"table table-striped table-bordered\">
            <tr class='table-info'>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Examen</th>
                <th>Nota</th>
            </tr>";

            // Recorrer los resultados y mostrar los datos en filas de la tabla
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>" . $row["nombre_alumno"] . "</td>
                <td>" . $row["nombre_curso"] . "</td>
                <td>" . $row["nombre_examen"] . "</td>
                <td>" . $row["nota"] . "</td>
            </tr>";
            }

            echo "</table>";
        } else {
            echo "No se encontraron alumnos vinculados al padre.";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
        <!-- Botón para imprimir tabla -->
    </div>
    <a class="no-print ms-3" type='button' onclick='imprimirTabla()'><img src='../Css/print.png' width='50px'></a>

    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Boletín</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header id="header" class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 id="titulo" style="text-align: center; color: #05429f">Boletín</h1>
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
                    <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action"><i class="bi bi-app pe-2" style="color: cornflowerblue;"></i>Página Principal</a>
                <?php
                } else {
                ?>
                    <a href="padre.php" class="list-group-item list-group-item-action"><i class="bi bi-app pe-2" style="color: cornflowerblue;"></i>Página Principal</a>
                <?php
                }
                ?>
                <a href="horarioHijo.php" class="list-group-item list-group-item-action"><i class="bi bi-calendar pe-2" style="color: cornflowerblue;"></i>Horarios</a>
                <a href="boletinHijo.php" class="list-group-item list-group-item-action active" aria-current="true"><i class="bi bi-card-list pe-2" style="color: cornflowerblue;"></i>Boletín</a>
                <a href="PassPadre.php" class="list-group-item list-group-item-action"><i class="bi bi-key pe-2" style="color: cornflowerblue;"></i>Cambiar Contraseña</a>
                <a class="dropdown-toggle list-group-item list-group-item-action" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-cash-coin  pe-2" style="color: cornflowerblue;"></i>Pagos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="cuotaPago/cuotasPagadas.php">Cuotas Pagadas</a></li>
                    <li><a class="dropdown-item" href="cuotaPago/pagar_cuota.php">Cuotas Pendientes</a></li>
                </ul>
            </div>
            <div style="position: fixed; bottom: 20px">
                <button class="btn btn-secondary" id="modo-daltonico-btn" onclick="activarModoDaltonico()">Modo Daltónico</button>
                <a href="..\index2.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
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
<script>
    function activarModoDaltonico() {
        // Obtener el estado actual del modo daltónico
        var modoDaltonico = obtenerModoDaltonico();

        // Cambiar el estado del modo daltónico
        modoDaltonico = !modoDaltonico;

        // Guardar el estado del modo daltónico en una cookie con una duración de 30 días
        document.cookie = "modoDaltonico=" + modoDaltonico + "; expires=" + obtenerFechaExpiracion(30);

        // Aplicar los cambios del modo daltónico
        aplicarModoDaltonico(modoDaltonico);
    }

    function obtenerModoDaltonico() {
        // Obtener el valor de la cookie de modoDaltonico
        var cookies = document.cookie.split(";");

        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].trim();

            // Verificar si la cookie es la de modoDaltonico
            if (cookie.indexOf("modoDaltonico=") === 0) {
                // Obtener el valor de la cookie
                var valor = cookie.substring("modoDaltonico=".length, cookie.length);

                // Convertir el valor a booleano
                return valor === "true";
            }
        }

        // Valor predeterminado si no se encuentra la cookie
        return false;
    }

    function aplicarModoDaltonico(modoDaltonico) {
        // Aquí puedes agregar el código para cambiar los estilos de tu página en modo daltónico
        // por ejemplo, cambiando los colores de fondo, texto, etc.

        if (modoDaltonico) {
            // Aplicar estilos para modo daltónico
            document.body.classList.add("modo-daltonico");
            document.getElementById("header").classList.add('modo-daltonico-header');
            // document.getElementById("titulo").classList.add('modo-daltonico-titulo');
            document.getElementById("titulo").style.color = "#f57600";

            const btnactive = document.querySelector('.active');
            btnactive.style.backgroundColor = 'yellow';
            btnactive.style.color = 'black';

            const btndanger = document.querySelector('.btn-danger');
            btndanger.style.backgroundColor = '#5ba300'
            btndanger.style.color = 'black';

            const btnprimary = document.querySelector('.btn-primary');
            btnprimary.style.backgroundColor = 'yellow';
            btnprimary.style.color = 'black';
        } else {
            // Quitar estilos de modo daltónico
            document.body.classList.remove("modo-daltonico");
            document.getElementById("header").classList.remove('modo-daltonico-header');
            document.getElementById("titulo").style.color = '#05429f';


            const btnactive = document.querySelector('.active');
            btnactive.style.backgroundColor = '#0d6efd';
            btnactive.style.color = 'white';

            const btndanger = document.querySelector('.btn-danger');
            btndanger.style.backgroundColor = '#dc3545'
            btndanger.style.color = 'white';

            const btnprimary = document.querySelector('.btn-primary');
            btnprimary.style.backgroundColor = '#0d6efd'
            btnprimary.style.color = 'white';
        }
    }

    function obtenerFechaExpiracion(dias) {
        var fecha = new Date();
        fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
        return fecha.toUTCString();
    }

    // Al cargar la página, aplicar el modo daltónico almacenado en la cookie
    window.onload = function() {
        var modoDaltonico = obtenerModoDaltonico();
        aplicarModoDaltonico(modoDaltonico);
    };
</script>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/styles.css">
    <title>Cambiar Contraseña</title>
</head>

<body>
    <!-- Código para la barra lateral -->
    <header class="header no-print">
        <!-- Cambiar título para que corresponda a la página -->
        <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <img src="../Css/hamburguesa.png" width="50px">
        </a>
        <h1 style="text-align: center; color: #05429f">Cambiar Contraseña</h1>
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
                <a href="../Autoridad/autoridad.php" class="list-group-item list-group-item-action" aria-current="true">Página Principal</a>
                <?php  
                }else{
                ?>
                <a href="Alumno.php" class="list-group-item list-group-item-action" aria-current="true">Página Principal</a>
                <?php 
                }
            ?>
        <a href="PassAlumno.php" class="list-group-item list-group-item-action active">Cambiar Contraseña</a>
        <a href="horarios.php" class="list-group-item list-group-item-action">Horarios</a>
        <a href="matricularCurso.php" class="list-group-item list-group-item-action">Matricularse</a>
        <a href="boletin.php" class="list-group-item list-group-item-action">Boletín</a>
            </div>
            <a href="..\index2.php" class="btn btn-danger" style="position: fixed; bottom: 20px">Cerrar sesión</a>
        </div>
    </div>
    <!-- Termina el bloque de código del sidebar -->


    <!-- Formulario para cambiar la contraseña -->
    <div class="card form-container mx-auto p-2 mt-3" style="width: 500px">
        <form method="POST">
            <div class="form-row">
                <label class="h5" for="current_password">Contraseña Actual:</label>
                <input class="form-control" type="password" name="current_password" required><br>
            </div>
            <div class="form-row">
                <label class="h5" for="new_password">Nueva Contraseña:</label>
                <input class="form-control" type="password" name="new_password" required><br>
            </div>
            <input class="btn btn-primary mt-2" type="submit" value="Cambiar Contraseña">
        </form>
    </div>


    <?php
    include '../conexion.php'; // Reemplaza 'conexion.php' con el archivo de conexión a tu base de datos

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        // Obtener el ID de usuario de la sesión
        $userId = $_SESSION['user_id'];

        // Realizar una consulta para obtener la contraseña actual del usuario
        $conn = conectar(); // Asegúrate de tener una función de conexión válida
        $sql = "SELECT password FROM alumno WHERE id = $userId";
        $result = $conn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['password'];

            // Verificar si la contraseña actual proporcionada coincide con la contraseña almacenada
            if ($currentPassword == $storedPassword) {
                // Actualizar la contraseña en la base de datos
                $updateSql = "UPDATE alumno SET password = '$newPassword' WHERE id = $userId";
                if ($conn->query($updateSql)) {
                    echo "<div class=\"alert-success mx-auto\" style=\"width: 500px\">
                    <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    Contraseña actualizada con éxito.
                  </div>";
                } else {
                    echo "<div class=\"alert mx-auto\" style=\"width: 500px\">
                    <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    Error al actualizar la contraseña: " . $conn->error . "
                  </div>";
                }
            } else {
                echo "<div class=\"alert mx-auto\" style=\"width: 500px\">
                <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                La contraseña actual no es válida.
              </div>";
            }
        } else {
            echo "<div class=\"alert mx-auto\" style=\"width: 500px\">
                    <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    Error al obtener la contraseña actual: " . $conn->error . "
                  </div>";
        }
        // Cierra la conexión a la base de datos
        $conn->close();
    }
    ?>
    <div id="footer">
        <img src="../Css/Logotipo200x200.png">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>
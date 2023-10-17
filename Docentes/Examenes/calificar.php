<!DOCTYPE html>
<html>
<head>
    <title>Ingresar Notas de Examen</title>
</head>
<body>
    <h1>Ingresar Notas de Examen</h1>
    <a href="examenes.php">Volver</a>
    <?php
    // Realizar la conexión a la base de datos
    require_once '../../conexion.php';

    $conn = conectar();

    // Verificar la conexión
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los datos del formulario
            $examenId = $_POST["examenId"];
            $legajoAlumno = $_POST["legajoAlumno"];
            $nota = $_POST["nota"];
    
            $sql = "SELECT nombre FROM examen WHERE id = '$examenId'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nombreExamen = $row["nombre"];
            } else {
                echo "No se encontró el examen con ese ID.";
            }
    
            $sql = "SELECT id FROM alumnos WHERE legajo = '$legajoAlumno'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $alumnoId = $row["id"];
    
                // Insertar la nota en la tabla "notas"
                $sql = "INSERT INTO nota (examen_id, alumno_id, valor) VALUES ('$examenId', '$alumnoId', '$nota')";
    
                if ($conn->query($sql) === TRUE) {
                    echo "La nota se ha ingresado correctamente.";
                } else {
                    echo "Error al ingresar la nota: " . $conn->error;
                }
            } else {
                echo "No se encontró el alumno con ese legajo.";
            }
        }
        ?>
    
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="examenId">Seleccionar Examen:</label>
            <select name="examenId" id="examenId" required>
                <?php
                $sql = "SELECT id, nombre FROM examen";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . "</option>";
                    }
                }
                ?>
            </select>
            <br><br>
            <label for="legajoAlumno">Legajo del Alumno:</label>
            <input type="text" name="legajoAlumno" id="legajoAlumno" required>
            <br><br>
            <label for="nota">Nota:</label>
            <input type="text" name="nota" id="nota" required>
            <br><br>
            <input type="submit" value="Ingresar Nota">
        </form>
    </body>
    </html>
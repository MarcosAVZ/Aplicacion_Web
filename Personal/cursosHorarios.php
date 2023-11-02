<a href="CuHo.php">Volver</a>
<!DOCTYPE html>
<html>
<head>
  <title>Formulario de Horarios</title>
</head>
<body>
  <h1>Formulario de Horarios</h1>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="dia">Día:</label>
    <select id="dia" name="dia">
      <option value="lunes">Lunes</option>
      <option value="martes">Martes</option>
      <option value="miercoles">Miércoles</option>
      <option value="jueves">Jueves</option>
      <option value="viernes">Viernes</option>
      <option value="sabado">Sábado</option>
    </select>
    <br>

    <label for="horaInicio">Hora de inicio:</label>
    <input type="time" id="horaInicio" name="horaInicio"><br>

    <label for="horaFin">Hora de fin:</label>
    <input type="time" id="horaFin" name="horaFin"><br>

    <label for="Aula">Aula:</label>
    <input type="text" id="Aula" name="Aula"><br>

    <input type="submit" value="Guardar">
  </form>

  <?php
  // Conexión a la base de datos
  include '../Conexion.php';

  // Conectarse a la base de datos
  $conn = conectar();

  // Verificar la conexión
  if ($conn->connect_error) {
      die("Error de conexión: " . $conn->connect_error);
  }

  // Procesar el formulario cuando se envíe
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $dia = $_POST["dia"];
      $horaInicio = $_POST["horaInicio"];
      $horaFin = $_POST["horaFin"];
      $Aula = $_POST["Aula"];

      // Consulta para insertar los datos en la tabla de horarios
      $sql = "INSERT INTO horario (dia, horaInicio, horaFin, Aula) VALUES ('$dia', '$horaInicio', '$horaFin', '$Aula')";

      if ($conn->query($sql) === TRUE) {
          echo "<p>Horario guardado exitosamente</p>";
      } else {
          echo "<p>Error al guardar el horario: " . $conn->error . "</p>";
      }
  }

  // Cerrar la conexión
  $conn->close();
  ?>
</body>
</html>
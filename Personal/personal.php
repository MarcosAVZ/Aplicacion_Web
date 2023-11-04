
<?php
// Establecer la conexión a la base de datos
require '../conexion.php';
$conexion = conectar();

/////////////////////////////////////Listado de pagos por parte de los alumnos////////////////////////////////////////////
if ($conexion->connect_errno) {
    die("Fallo la conexion: (" . $conexion->connect_errno . ")" . $conexion->connect_error);
}
?>

<html lang="es">
    <head>
    <a href="../index2.php">Cerrar Sesion</a>
	<form method="post" action="personal.php">
        <title>Filtro de pagos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    </head>
    <body>
        <header>
        </header>
            <a href="totalAlumnos.php">Alumnos</a>
            <a href="CuHo.php">Cursos</a>
            <a href="Cuotas/IntermedioCuota.php">Cuotas</a>
    </body>
</html>
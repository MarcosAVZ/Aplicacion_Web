-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-11-2023 a las 23:12:25
-- Versión del servidor: 10.5.20-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id21307637_aplicacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `idPadre` int(11) DEFAULT NULL,
  `legajo` int(30) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `correo`, `password`, `idPadre`, `legajo`, `nombre`) VALUES
(1, 'alumno1@mail.com', '1234', 1, 123, 'Pablo Perez'),
(2, 'alumno2@mail.com', '5678', 2, 456, 'Gimena Baron'),
(3, 'alumno3@mail.com', '9012', 3, 789, 'Santiago lopez'),
(4, 'alumno4@mail.com', '1234', 2, 124, 'Palacio Fernandez'),
(8, 'pruebaalumno@gagsa.com', 'pruebaalumno@gagsa.com', 3, 12335, 'Prueba manuel'),
(10, 'alumno1@mail.com', 'alumno1@mail.com', 3, 1, 'sdadsadssa'),
(11, 'padre1@mail.com', 'padre1@mail.com', 4, 101, 'uelanM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnocurso`
--

CREATE TABLE `alumnocurso` (
  `idAlumno` int(11) NOT NULL,
  `idCurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `alumnocurso`
--

INSERT INTO `alumnocurso` (`idAlumno`, `idCurso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoridad`
--

CREATE TABLE `autoridad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autoridad`
--

INSERT INTO `autoridad` (`id`, `nombre`, `correo`, `password`) VALUES
(1, 'Autoridad 1', 'autoridad1@example.com', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `comentario` text NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `nombre_usuario`, `comentario`, `puntuacion`, `fecha_creacion`) VALUES
(1, 'Anónimo', 'sdads', 1, '2023-09-25 16:24:50'),
(2, 'Anónimo', 'Buenas', 3, '2023-09-25 16:24:58'),
(3, 'Anónimo', 'Buenas', 3, '2023-09-25 16:26:40'),
(4, 'Anónimo', 'Buenass', 5, '2023-09-25 16:26:54'),
(5, 'Anónimo', 'Buenass', 3, '2023-09-25 16:28:00'),
(6, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:05:19'),
(7, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:05:21'),
(8, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:05:22'),
(9, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:05:25'),
(10, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:06:15'),
(11, 'Anónimo', 'Hola', 5, '2023-11-06 18:30:54'),
(12, 'Anónimo', 'Hola', 5, '2023-11-06 18:37:39'),
(13, 'Anónimo', 'dadsadsa', 1, '2023-11-06 18:39:17'),
(14, 'Anónimo', 'dadsadsa', 1, '2023-11-06 18:44:22'),
(15, 'Anónimo', 'Paapaa', 3, '2023-11-06 18:44:35'),
(16, 'Anónimo', 'Paapaa', 3, '2023-11-06 18:47:39'),
(17, 'Anónimo', 'asdasda', 2, '2023-11-06 18:47:55'),
(18, 'Padre 1', 'asdasda', 2, '2023-11-06 18:49:41'),
(19, 'Padre 1', 'asdasda', 2, '2023-11-06 18:52:32'),
(20, 'Padre 1', 'asdadsa', 1, '2023-11-06 18:52:43'),
(21, 'Anónimo', 'asdadsad', 3, '2023-11-06 18:56:28'),
(22, 'Padre 1', 'adsada', 3, '2023-11-06 18:56:46'),
(1, 'Anónimo', 'sdads', 1, '2023-09-25 16:24:50'),
(2, 'Anónimo', 'Buenas', 3, '2023-09-25 16:24:58'),
(3, 'Anónimo', 'Buenas', 3, '2023-09-25 16:26:40'),
(4, 'Anónimo', 'Buenass', 5, '2023-09-25 16:26:54'),
(5, 'Anónimo', 'Buenass', 3, '2023-09-25 16:28:00'),
(6, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:05:19'),
(7, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:05:21'),
(8, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:05:22'),
(9, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:05:25'),
(10, 'Anónimo', 'Hola comentario', 4, '2023-09-25 22:06:15'),
(11, 'Anónimo', 'Hola', 5, '2023-11-06 18:30:54'),
(12, 'Anónimo', 'Hola', 5, '2023-11-06 18:37:39'),
(13, 'Anónimo', 'dadsadsa', 1, '2023-11-06 18:39:17'),
(14, 'Anónimo', 'dadsadsa', 1, '2023-11-06 18:44:22'),
(15, 'Anónimo', 'Paapaa', 3, '2023-11-06 18:44:35'),
(16, 'Anónimo', 'Paapaa', 3, '2023-11-06 18:47:39'),
(17, 'Anónimo', 'asdasda', 2, '2023-11-06 18:47:55'),
(18, 'Padre 1', 'asdasda', 2, '2023-11-06 18:49:41'),
(19, 'Padre 1', 'asdasda', 2, '2023-11-06 18:52:32'),
(20, 'Padre 1', 'asdadsa', 1, '2023-11-06 18:52:43'),
(21, 'Anónimo', 'asdadsad', 3, '2023-11-06 18:56:28'),
(22, 'Padre 1', 'adsada', 3, '2023-11-06 18:56:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuota`
--

CREATE TABLE `cuota` (
  `id` int(11) NOT NULL,
  `mes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `cuota`
--

INSERT INTO `cuota` (`id`, `mes`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotapadre`
--

CREATE TABLE `cuotapadre` (
  `idPadre` int(11) NOT NULL,
  `idCuota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotapersonal`
--

CREATE TABLE `cuotapersonal` (
  `idCuota` int(11) NOT NULL,
  `idPersonal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id` int(11) NOT NULL,
  `id_padre` int(11) DEFAULT NULL,
  `idAlumno` int(11) DEFAULT NULL,
  `mes` varchar(15) DEFAULT NULL,
  `año` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `estado` enum('pendiente','pagado') DEFAULT NULL,
  `nivelAumento` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuotas`
--

INSERT INTO `cuotas` (`id`, `id_padre`, `idAlumno`, `mes`, `año`, `monto`, `estado`, `nivelAumento`) VALUES
(1, 1, 1, 'Enero', 2023, 100.00, 'pagado', 0),
(2, 1, 1, 'Febrero', 2023, 150.00, 'pagado', 0),
(3, 1, 2, 'Marzo', 2024, 100.00, 'pagado', 0),
(4, 1, 1, 'Abril', 2024, 220.00, 'pagado', 2),
(5, 1, 2, 'Mayo', 2024, 330.00, 'pendiente', 2),
(62, 1, 1, 'Noviembre', 2023, 10000.02, 'pendiente', NULL),
(65, 2, 2, 'Noviembre', 2023, 10000.02, 'pendiente', NULL),
(66, 2, 4, 'Noviembre', 2023, 10000.02, 'pendiente', NULL),
(67, 3, 3, 'Noviembre', 2023, 10000.02, 'pendiente', NULL),
(68, 4, 11, 'Noviembre', 2023, 10000.00, 'pendiente', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id`, `nombre`) VALUES
(1, 'Matematicas'),
(2, 'Lengua'),
(3, 'Historia'),
(5, 'Ciencias Sociales'),
(8, 'Ciencias Naturales'),
(9, 'Quimica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursodocente`
--

CREATE TABLE `cursodocente` (
  `idCurso` int(11) NOT NULL,
  `idDocente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `cursodocente`
--

INSERT INTO `cursodocente` (`idCurso`, `idDocente`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursohorario`
--

CREATE TABLE `cursohorario` (
  `idCurso` int(11) NOT NULL,
  `idHorario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `cursohorario`
--

INSERT INTO `cursohorario` (`idCurso`, `idHorario`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 2),
(2, 20),
(3, 22),
(5, 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursopersonal`
--

CREATE TABLE `cursopersonal` (
  `idCurso` int(11) NOT NULL,
  `idPersonal` int(11) NOT NULL,
  `aula` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `legajo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id`, `nombre`, `correo`, `password`, `legajo`) VALUES
(1, 'Pepe Argento', 'pepe@mail.com', '1234', '123'),
(2, 'Pablo', 'juan@mail.com', '5678', '456'),
(3, 'Lalo', 'maria@mail.com', '9012', '789');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `idCurso` int(11) DEFAULT NULL,
  `idDocente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`id`, `nombre`, `idCurso`, `idDocente`) VALUES
(1, 'Parcial 1', 1, 1),
(2, 'Parcial 2', 1, 1),
(3, 'Parcial 2', 2, 1),
(4, 'Parcial 3', 2, 1),
(5, 'Parcial 2', 2, 1),
(6, 'Parcial 3', 2, 1),
(7, 'Segunda Parcial', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenalumno`
--

CREATE TABLE `examenalumno` (
  `idAlumno` int(11) NOT NULL,
  `idExamen` int(11) NOT NULL,
  `nota` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `examenalumno`
--

INSERT INTO `examenalumno` (`idAlumno`, `idExamen`, `nota`) VALUES
(1, 1, 6),
(1, 2, 12),
(1, 4, 6),
(2, 3, 9),
(2, 4, 6),
(2, 7, 10),
(3, 5, 7),
(3, 6, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id` int(11) NOT NULL,
  `dia` varchar(50) DEFAULT NULL,
  `horaInicio` time DEFAULT NULL,
  `horaFin` time DEFAULT NULL,
  `Aula` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id`, `dia`, `horaInicio`, `horaFin`, `Aula`) VALUES
(1, 'Lunes', '08:00:00', '09:30:00', 'Aula1'),
(2, 'Martes', '10:00:00', '11:30:00', 'Aula2'),
(3, 'Jueves', '13:00:00', '14:30:00', 'Aula1'),
(20, 'lunes', '16:45:00', '18:45:00', '5,2'),
(21, 'Martes', '16:45:00', '18:45:00', '5,2'),
(22, 'viernes', '06:30:00', '12:25:00', '2,10'),
(23, 'lunes', '17:39:00', '19:41:00', '2,11'),
(24, 'viernes', '17:20:00', '18:21:00', '2,10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monto`
--

CREATE TABLE `monto` (
  `id` int(11) NOT NULL,
  `interes` int(11) DEFAULT NULL,
  `monto` double DEFAULT NULL,
  `idCuota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montos_cuota`
--

CREATE TABLE `montos_cuota` (
  `id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `montos_cuota`
--

INSERT INTO `montos_cuota` (`id`, `monto`) VALUES
(1, 10000.00),
(1, 10000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `imagen` longblob DEFAULT NULL,
  `tipo_imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `contenido`, `fecha`, `imagen`, `tipo_imagen`) VALUES
(2, 'La Institución Implementa Programa de Educación Ambiental', 'Estamos dando un paso adelante en la promoción de la conciencia ambiental entre nuestros estudiantes al lanzar un nuevo programa de educación ambiental destinado a inspirar la conservación y la sostenibilidad', '2023-09-23 00:00:00', NULL, NULL),
(3, 'La Institucion Fomenta la Creatividad de sus Estudiantes', 'Educar Para Transformar está comprometida con el desarrollo integral de sus estudiantes y, este año, ha implementado una serie de iniciativas para fomentar la creatividad y la innovación en el aula.', '2023-09-21 00:00:00', NULL, NULL),
(4, 'Celebración de la Primavera en \'EDUCAR PARA TRANSFORMAR\': Día del Estudiante lleno de flores Rojas y hermosas', 'La llegada de la primavera trajo consigo una explosión de alegría y color en el Centro Educativo \"EDUCAR PARA TRANSFORMAR\". Como parte de la tradición arraigada en la institución, el Día del Estudiante se celebra con regalos de flores amarillas. <br /><br />\r\nEl evento culminó con un emotivo acto en el que se destacaron los logros académicos y extracurriculares de los estudiantes. Además, se reconoció a aquellos que habían contribuido de manera significativa al ambiente positivo y colaborativo de la institución.', NULL, NULL, NULL),
(5, 'Noticia prueba', 'Esta es una simple noticia', NULL, NULL, NULL),
(2, 'La Institución Implementa Programa de Educación Ambiental', 'Estamos dando un paso adelante en la promoción de la conciencia ambiental entre nuestros estudiantes al lanzar un nuevo programa de educación ambiental destinado a inspirar la conservación y la sostenibilidad', '2023-09-23 00:00:00', NULL, NULL),
(3, 'La Institucion Fomenta la Creatividad de sus Estudiantes', 'Educar Para Transformar está comprometida con el desarrollo integral de sus estudiantes y, este año, ha implementado una serie de iniciativas para fomentar la creatividad y la innovación en el aula.', '2023-09-21 00:00:00', NULL, NULL),
(4, 'Celebración de la Primavera en \'EDUCAR PARA TRANSFORMAR\': Día del Estudiante lleno de flores Rojas y hermosas', 'La llegada de la primavera trajo consigo una explosión de alegría y color en el Centro Educativo \"EDUCAR PARA TRANSFORMAR\". Como parte de la tradición arraigada en la institución, el Día del Estudiante se celebra con regalos de flores amarillas. <br /><br />\r\nEl evento culminó con un emotivo acto en el que se destacaron los logros académicos y extracurriculares de los estudiantes. Además, se reconoció a aquellos que habían contribuido de manera significativa al ambiente positivo y colaborativo de la institución.', NULL, NULL, NULL),
(5, 'Noticia prueba', 'Esta es una simple noticia', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `padre`
--

CREATE TABLE `padre` (
  `id` int(11) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `legajo` int(30) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `padre`
--

INSERT INTO `padre` (`id`, `correo`, `password`, `legajo`, `nombre`) VALUES
(1, 'padre1@mail.com', '1234', 123, 'Padre 1'),
(2, 'padre2@mail.com', '5678', 456, 'Padre 2'),
(3, 'padre3@mail.com', '9012', 789, 'Padre 3'),
(4, 'padrePrueba@mail.com', 'padrePrueba@mail.com', 1231213, 'Marcos Avanzatti'),
(6, 'padre1@mail.com', 'padre1@mail.com', 1, 'Prueba manuel'),
(7, 'alumno1@mail.com', 'alumno1@mail.com', 12312, 'wdadw');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` int(11) NOT NULL,
  `montoPago` decimal(10,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `idCuota` int(11) DEFAULT NULL,
  `nroComprobante` int(20) NOT NULL,
  `comprobante` blob DEFAULT NULL,
  `metodo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id`, `montoPago`, `fecha`, `idCuota`, `nroComprobante`, `comprobante`, `metodo`) VALUES
(1, 50.00, '2023-11-04', 1, 2147483647, NULL, ''),
(2, 50.00, '2023-11-03', 1, 2147483647, 0x7061676f202831292e73716c, ''),
(3, 50.00, '2023-11-03', 3, 2147483647, 0x7061676f2e73716c, ''),
(4, 50.00, '2023-11-03', 3, 2147483647, 0x7061676f2e73716c, ''),
(5, 100.00, '2023-11-04', 1, 2147483647, 0x7061676f2e73716c, ''),
(6, 100.00, '2023-11-04', 2, 2147483647, 0x7061676f2e73716c, ''),
(7, 50.00, '2023-11-04', 2, 2147483647, 0x7061676f2e73716c, ''),
(8, 50.00, '2023-11-04', 4, 2147483647, 0x7061676f2e73716c, ''),
(9, 50.00, '2023-11-04', 4, 2147483647, 0x7061676f2e73716c, 'Efectivo'),
(10, 50.00, '2023-11-04', 4, 2147483647, 0x6e6f746120646520736f6c696369747564206465206c6963656e6369612031305f2d30342e706466, 'Efectivo'),
(11, 50.00, '2023-11-06', 4, 2147483647, 0x68746163636573732e747874, 'Crédito'),
(14, 100.00, '2023-11-13', 4, 21231321, 0x63756f746173202831292e73716c, 'Crédito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `legajo` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id`, `legajo`, `correo`, `password`, `nombre`) VALUES
(1, '123', 'empleado1@mail.com', '1234', 'Empleado 1'),
(2, '456', 'empleado2@mail.com', '5678', 'Empleado 2'),
(3, '789', 'empleado3@mail.com', '9012', 'Empleado 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Volcado de datos para la tabla `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('id21307637_marcos', '[{\"db\":\"id21307637_aplicacion\",\"table\":\"autoridad\"},{\"db\":\"id21307637_aplicacion\",\"table\":\"cursodocente\"},{\"db\":\"id21307637_aplicacion\",\"table\":\"docente\"},{\"db\":\"id21307637_aplicacion\",\"table\":\"cursopersonal\"},{\"db\":\"id21307637_aplicacion\",\"table\":\"curso\"},{\"db\":\"id21307637_aplicacion\",\"table\":\"alumno\"},{\"db\":\"id21307637_aplicacion\",\"table\":\"alumnocurso\"},{\"db\":\"id21307637_aplicacion\",\"table\":\"montos_cuota\"},{\"db\":\"id21307637_aplicacion\",\"table\":\"cuotas\"},{\"db\":\"id21307637_aplicacion\",\"table\":\"cuotapadre\"}]'),
('root', '[{\"db\":\"phpmyadmin\",\"table\":\"alumno\"},{\"db\":\"phpmyadmin\",\"table\":\"examenalumno\"},{\"db\":\"phpmyadmin\",\"table\":\"examen\"},{\"db\":\"phpmyadmin\",\"table\":\"alumnocurso\"},{\"db\":\"phpmyadmin\",\"table\":\"curso\"},{\"db\":\"phpmyadmin\",\"table\":\"padre\"},{\"db\":\"phpmyadmin\",\"table\":\"horario\"},{\"db\":\"phpmyadmin\",\"table\":\"cursohorario\"},{\"db\":\"phpmyadmin\",\"table\":\"personal\"},{\"db\":\"pagointer\",\"table\":\"products\"}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Volcado de datos para la tabla `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'phpmyadmin', 'horario', '{\"CREATE_TIME\":\"2023-10-26 19:45:12\"}', '2023-10-31 17:47:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Volcado de datos para la tabla `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('id21307637_marcos', '2023-11-13 17:54:45', '{\"lang\":\"es\",\"Console\\/Mode\":\"collapse\"}'),
('root', '2023-10-31 16:37:45', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"es\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPadre` (`idPadre`);

--
-- Indices de la tabla `alumnocurso`
--
ALTER TABLE `alumnocurso`
  ADD PRIMARY KEY (`idAlumno`,`idCurso`),
  ADD KEY `idCurso` (`idCurso`);

--
-- Indices de la tabla `autoridad`
--
ALTER TABLE `autoridad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuota`
--
ALTER TABLE `cuota`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuotapadre`
--
ALTER TABLE `cuotapadre`
  ADD PRIMARY KEY (`idPadre`,`idCuota`),
  ADD KEY `idCuota` (`idCuota`);

--
-- Indices de la tabla `cuotapersonal`
--
ALTER TABLE `cuotapersonal`
  ADD PRIMARY KEY (`idCuota`,`idPersonal`),
  ADD KEY `idPersonal` (`idPersonal`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_padre` (`id_padre`),
  ADD KEY `fk_idAlumno` (`idAlumno`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursodocente`
--
ALTER TABLE `cursodocente`
  ADD PRIMARY KEY (`idCurso`,`idDocente`),
  ADD KEY `cursodocente_ibfk_2` (`idDocente`);

--
-- Indices de la tabla `cursohorario`
--
ALTER TABLE `cursohorario`
  ADD PRIMARY KEY (`idCurso`,`idHorario`),
  ADD KEY `cursohorario_ibfk_2` (`idHorario`);

--
-- Indices de la tabla `cursopersonal`
--
ALTER TABLE `cursopersonal`
  ADD PRIMARY KEY (`idCurso`,`idPersonal`),
  ADD KEY `idPersonal` (`idPersonal`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCurso` (`idCurso`),
  ADD KEY `FK_examen_Docente` (`idDocente`);

--
-- Indices de la tabla `examenalumno`
--
ALTER TABLE `examenalumno`
  ADD PRIMARY KEY (`idAlumno`,`idExamen`),
  ADD KEY `idExamen` (`idExamen`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `monto`
--
ALTER TABLE `monto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCuota` (`idCuota`);

--
-- Indices de la tabla `padre`
--
ALTER TABLE `padre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCuota` (`idCuota`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indices de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indices de la tabla `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indices de la tabla `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indices de la tabla `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indices de la tabla `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indices de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indices de la tabla `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indices de la tabla `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indices de la tabla `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indices de la tabla `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indices de la tabla `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `autoridad`
--
ALTER TABLE `autoridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cuota`
--
ALTER TABLE `cuota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `monto`
--
ALTER TABLE `monto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `padre`
--
ALTER TABLE `padre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`idPadre`) REFERENCES `padre` (`id`);

--
-- Filtros para la tabla `alumnocurso`
--
ALTER TABLE `alumnocurso`
  ADD CONSTRAINT `alumnocurso_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `alumnocurso_ibfk_2` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`id`);

--
-- Filtros para la tabla `cuotapadre`
--
ALTER TABLE `cuotapadre`
  ADD CONSTRAINT `cuotapadre_ibfk_1` FOREIGN KEY (`idPadre`) REFERENCES `padre` (`id`),
  ADD CONSTRAINT `cuotapadre_ibfk_2` FOREIGN KEY (`idCuota`) REFERENCES `cuota` (`id`);

--
-- Filtros para la tabla `cuotapersonal`
--
ALTER TABLE `cuotapersonal`
  ADD CONSTRAINT `cuotapersonal_ibfk_1` FOREIGN KEY (`idCuota`) REFERENCES `cuota` (`id`),
  ADD CONSTRAINT `cuotapersonal_ibfk_2` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`id`);

--
-- Filtros para la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD CONSTRAINT `cuotas_ibfk_1` FOREIGN KEY (`id_padre`) REFERENCES `padre` (`id`),
  ADD CONSTRAINT `fk_idAlumno` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `cursodocente`
--
ALTER TABLE `cursodocente`
  ADD CONSTRAINT `cursodocente_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `cursodocente_ibfk_2` FOREIGN KEY (`idDocente`) REFERENCES `docente` (`id`);

--
-- Filtros para la tabla `cursohorario`
--
ALTER TABLE `cursohorario`
  ADD CONSTRAINT `cursohorario_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `cursohorario_ibfk_2` FOREIGN KEY (`idHorario`) REFERENCES `horario` (`id`);

--
-- Filtros para la tabla `cursopersonal`
--
ALTER TABLE `cursopersonal`
  ADD CONSTRAINT `cursopersonal_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `cursopersonal_ibfk_2` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`id`);

--
-- Filtros para la tabla `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `FK_examen_Docente` FOREIGN KEY (`idDocente`) REFERENCES `docente` (`id`),
  ADD CONSTRAINT `examen_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`id`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`idCuota`) REFERENCES `cuotas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2023 a las 17:17:34
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aplicacionpago`
--

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
  `estado` enum('pendiente','pagado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuotas`
--

INSERT INTO `cuotas` (`id`, `id_padre`, `idAlumno`, `mes`, `año`, `monto`, `estado`) VALUES
(1, 1, 1, 'Enero', 2023, 100.00, 'pagado'),
(2, 1, 1, 'Febrero', 2023, 150.00, 'pagado'),
(3, 1, 2, 'Marzo', 2024, 100.00, 'pagado'),
(4, 1, 1, 'Abril', 2024, 200.00, 'pagado'),
(5, 1, 2, 'Mayo', 2024, 300.00, 'pendiente'),
(38, 1, 1, 'November', 2023, 10000.00, 'pendiente'),
(39, 1, 2, 'November', 2023, 10000.00, 'pendiente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_padre` (`id_padre`),
  ADD KEY `fk_idAlumno` (`idAlumno`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD CONSTRAINT `cuotas_ibfk_1` FOREIGN KEY (`id_padre`) REFERENCES `padre` (`id`),
  ADD CONSTRAINT `fk_idAlumno` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

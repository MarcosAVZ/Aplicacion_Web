-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-11-2023 a las 00:30:17
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
(12, 1200.00, '2023-11-11', 56, 12313, 0x416c7461205965737369636120522e3135312e706466, 'Efectivo'),
(13, 500.00, '2023-11-12', 56, 21231321, 0x545020556e6964616420362d323032332e646f6378, 'Crédito');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCuota` (`idCuota`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`idCuota`) REFERENCES `cuotas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

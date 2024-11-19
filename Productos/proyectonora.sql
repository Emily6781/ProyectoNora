-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2024 a las 18:51:06
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_nora`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(45) DEFAULT NULL,
  `FechaVisita` date DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `Comanetario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(45) DEFAULT NULL,
  `ApellidoP` varchar(45) DEFAULT NULL,
  `ApellidoM` varchar(45) DEFAULT NULL,
  `FechaNac` date DEFAULT NULL,
  `Puestos_ID` int(11) DEFAULT NULL,
  `Horario_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `ID` int(11) NOT NULL,
  `Horario` varchar(45) DEFAULT NULL,
  `HoraEntrada` time DEFAULT NULL,
  `HoraSalida` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `datos` longblob NOT NULL,
  `producto_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modopago`
--

CREATE TABLE `modopago` (
  `ID` int(11) NOT NULL,
  `Modo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(45) DEFAULT NULL,
  `Precio` int(11) DEFAULT NULL,
  `Tipo_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID`, `Nombre`, `Precio`, `Tipo_ID`) VALUES
(28, 'mexicos', 56, 2),
(29, 'jonny', 344, 3),
(31, 'jonny21', 12, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `ID` int(11) NOT NULL,
  `Puesto` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `ID` int(11) NOT NULL,
  `Tipo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`ID`, `Tipo`) VALUES
(1, 'Postres'),
(2, 'Bebidas'),
(3, 'Desayunos'),
(4, 'Aperitivos'),
(5, 'Comidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `ID` int(11) NOT NULL,
  `Productos_ID` int(11) DEFAULT NULL,
  `Empleado_ID` int(11) DEFAULT NULL,
  `Cliente_ID` int(11) DEFAULT NULL,
  `ModoPago_ID` int(11) DEFAULT NULL,
  `Total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Puestos_ID` (`Puestos_ID`),
  ADD KEY `Horario_ID` (`Horario_ID`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `modopago`
--
ALTER TABLE `modopago`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Tipo_ID` (`Tipo_ID`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Productos_ID` (`Productos_ID`),
  ADD KEY `Empleado_ID` (`Empleado_ID`),
  ADD KEY `Cliente_ID` (`Cliente_ID`),
  ADD KEY `ModoPago_ID` (`ModoPago_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `modopago`
--
ALTER TABLE `modopago`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`Puestos_ID`) REFERENCES `puestos` (`ID`),
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`Horario_ID`) REFERENCES `horarios` (`ID`);

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Tipo_ID`) REFERENCES `tipos` (`ID`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`Productos_ID`) REFERENCES `productos` (`ID`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`Empleado_ID`) REFERENCES `empleados` (`ID`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`Cliente_ID`) REFERENCES `clientes` (`ID`),
  ADD CONSTRAINT `ventas_ibfk_4` FOREIGN KEY (`ModoPago_ID`) REFERENCES `modopago` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

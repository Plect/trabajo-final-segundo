-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 13-04-2026 a las 18:42:52
-- Versión del servidor: 8.0.45
-- Versión de PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pecera_digital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_corales`
--

CREATE TABLE `catalogo_corales` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `precio` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `catalogo_corales`
--

INSERT INTO `catalogo_corales` (`id`, `nombre`, `tipo`, `precio`) VALUES
(301, 'Coral Rojo', 'images/coral_rojo.png', 20),
(302, 'Coral Tubo', 'images/coral_tubo.png', 30),
(303, 'Anémona', 'images/anemona.png', 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_decoraciones`
--

CREATE TABLE `catalogo_decoraciones` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `precio` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `catalogo_decoraciones`
--

INSERT INTO `catalogo_decoraciones` (`id`, `nombre`, `tipo`, `precio`) VALUES
(201, 'Piedra Lisa', 'images/piedra.png', 5),
(202, 'Estrella Marina', 'images/estrella.png', 15),
(203, 'Concha', 'images/concha.png', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_peces`
--

CREATE TABLE `catalogo_peces` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` blob NOT NULL,
  `precio` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `catalogo_peces`
--

INSERT INTO `catalogo_peces` (`id`, `nombre`, `tipo`, `precio`) VALUES
(101, 'Pez Payaso', 0x696d616765732f70657a5f70617961736f2e706e67, 10),
(102, 'Pez Cirujano Azul', 0x696d616765732f70657a5f636972756a616e6f2e706e67, 25),
(103, 'Pez Ángel', 0x696d616765732f70657a5f616e67656c2e706e67, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `pez_id` int NOT NULL,
  `cantidad` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_corales`
--

CREATE TABLE `inventario_corales` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `coral_id` int NOT NULL,
  `cantidad` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_decoraciones`
--

CREATE TABLE `inventario_decoraciones` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `decoracion_id` int NOT NULL,
  `cantidad` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dinero` int DEFAULT '90',
  `nivel` int DEFAULT '1',
  `xp_actual` int DEFAULT '0',
  `xp_max` int DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogo_corales`
--
ALTER TABLE `catalogo_corales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catalogo_decoraciones`
--
ALTER TABLE `catalogo_decoraciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `catalogo_peces`
--
ALTER TABLE `catalogo_peces`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `pez_id` (`pez_id`);

--
-- Indices de la tabla `inventario_corales`
--
ALTER TABLE `inventario_corales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `coral_id` (`coral_id`);

--
-- Indices de la tabla `inventario_decoraciones`
--
ALTER TABLE `inventario_decoraciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `decoracion_id` (`decoracion_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo_peces`
--
ALTER TABLE `catalogo_peces`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `inventario_corales`
--
ALTER TABLE `inventario_corales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inventario_decoraciones`
--
ALTER TABLE `inventario_decoraciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`pez_id`) REFERENCES `catalogo_peces` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventario_corales`
--
ALTER TABLE `inventario_corales`
  ADD CONSTRAINT `inventario_corales_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventario_corales_ibfk_2` FOREIGN KEY (`coral_id`) REFERENCES `catalogo_corales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventario_decoraciones`
--
ALTER TABLE `inventario_decoraciones`
  ADD CONSTRAINT `inventario_decoraciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventario_decoraciones_ibfk_2` FOREIGN KEY (`decoracion_id`) REFERENCES `catalogo_decoraciones` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

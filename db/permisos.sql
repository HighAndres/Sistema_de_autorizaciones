-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2020 a las 18:41:04
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `permisos`
--
CREATE DATABASE IF NOT EXISTS `permisos` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `permisos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_salida`
--

CREATE TABLE `entrada_salida` (
  `id_es` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `tipo_empleado` varchar(25) NOT NULL,
  `nombre_solicitante` varchar(100) NOT NULL,
  `departamento` varchar(80) NOT NULL,
  `num_nomina` bigint(100) NOT NULL,
  `hora_salida` time NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `fecha_entrada` date NOT NULL,
  `inasistencia_del` date NOT NULL,
  `inasistencia_al` date NOT NULL,
  `goce_sueldo` varchar(11) NOT NULL,
  `observaciones` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `email`, `password`) VALUES
(1, 'pvaladez@tubosybarras.com', '123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacaciones`
--

CREATE TABLE `vacaciones` (
  `id_vcns` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `nombre_solicitante` varchar(100) NOT NULL,
  `departamento` varchar(80) NOT NULL,
  `num_nomina` bigint(100) NOT NULL,
  `puesto` varchar(100) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `num_dias_vcns` int(30) DEFAULT NULL,
  `periodo1` year(4) DEFAULT NULL,
  `num_dias_a_difrutar` int(30) DEFAULT NULL,
  `dias_a_difrutar_del` date DEFAULT NULL,
  `dias_a_difrutar_al` date DEFAULT NULL,
  `regreso` date DEFAULT NULL,
  `dias_restantes` int(30) DEFAULT NULL,
  `periodo_restantes1` year(4) DEFAULT NULL,
  `periodo_restantes2` year(4) DEFAULT NULL,
  `prima_vacacional` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vacaciones`
--

INSERT INTO `vacaciones` (`id_vcns`, `fecha_registro`, `nombre_solicitante`, `departamento`, `num_nomina`, `puesto`, `fecha_ingreso`, `num_dias_vcns`, `periodo1`, `num_dias_a_difrutar`, `dias_a_difrutar_del`, `dias_a_difrutar_al`, `regreso`, `dias_restantes`, `periodo_restantes1`, `periodo_restantes2`, `prima_vacacional`) VALUES
(1, '2020-08-14', 'ERTYUI', 'MANTENIMIENTO', 111, 'OOL', '2020-08-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `entrada_salida`
--
ALTER TABLE `entrada_salida`
  ADD PRIMARY KEY (`id_es`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `vacaciones`
--
ALTER TABLE `vacaciones`
  ADD PRIMARY KEY (`id_vcns`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entrada_salida`
--
ALTER TABLE `entrada_salida`
  MODIFY `id_es` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `vacaciones`
--
ALTER TABLE `vacaciones`
  MODIFY `id_vcns` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

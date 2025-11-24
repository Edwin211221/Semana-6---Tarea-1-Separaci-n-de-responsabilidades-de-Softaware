-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 19-03-2024 a las 14:19:17
-- Versión del servidor: 5.7.39
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Ingresos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Accesos`
--

CREATE TABLE `Accesos` (
  `idAccesos` int(11) NOT NULL,
  `IdTipoAcceso` int(11) NOT NULL,
  `Ultimo` datetime NOT NULL,
  `Usuarios_idUsuarios` int(11) DEFAULT NULL,
  `imagen` text NOT NULL,
  `EmpleadoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Accesos`
--

INSERT INTO `Accesos` (`idAccesos`, `IdTipoAcceso`, `Ultimo`, `Usuarios_idUsuarios`, `imagen`, `EmpleadoId`) VALUES
(33, 1, '2024-02-04 21:34:36', NULL, '../../public/images/registros/2-20240305023436.', 2),
(34, 2, '2024-03-04 21:37:10', NULL, '../../public/images/registros/20240305023710.png', 2),
(35, 1, '2024-01-05 09:05:21', NULL, '../../public/images/registros/20240305140521.png', 2),
(36, 1, '2024-01-05 09:06:45', NULL, '../../public/images/registros/20240305140645.png', 2),
(37, 1, '2024-02-05 09:08:17', NULL, '../../public/images/registros/20240305140817.png', 6),
(38, 1, '2024-03-05 09:09:09', NULL, '../../public/images/registros/20240305140909.png', 2),
(39, 1, '2024-03-06 09:41:53', NULL, '../../public/images/registros/20240306144153.png', 2),
(40, 1, '2024-03-11 18:52:23', NULL, '../../public/images/registros/20240311235223.png', 2),
(41, 1, '2024-03-12 15:11:22', NULL, '../../public/images/registros/20240312201122.png', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Empleado`
--

CREATE TABLE `Empleado` (
  `EmpleadoId` int(11) NOT NULL,
  `Nombres` text NOT NULL,
  `Apellidos` text NOT NULL,
  `Direccion` text NOT NULL,
  `Telefono` text NOT NULL,
  `Cedula` text NOT NULL,
  `Correo` text NOT NULL,
  `RolId` int(11) NOT NULL,
  `SucursalId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Empleado`
--

INSERT INTO `Empleado` (`EmpleadoId`, `Nombres`, `Apellidos`, `Direccion`, `Telefono`, `Cedula`, `Correo`, `RolId`, `SucursalId`) VALUES
(2, 'Usuario ', '1', 'RAZO RAZO', '0981030167', '1803971371', 'lleroc1@gmail.com', 5, 5),
(6, 'Usuario', '3', 'RAZO RAZO', '0981030167', '1803971372', 'kjbs@gmail.com', 6, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Faltas`
--

CREATE TABLE `Faltas` (
  `FaltaId` int(11) NOT NULL,
  `EmpleadoId` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Observacion` text NOT NULL,
  `archivo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Faltas`
--

INSERT INTO `Faltas` (`FaltaId`, `EmpleadoId`, `Fecha`, `Observacion`, `archivo`) VALUES
(15, 2, '2024-02-01', 'cambios jsdhabvdflkjhbldhjs', '../../public/justificaciones/20240315221805.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Roles`
--

CREATE TABLE `Roles` (
  `idRoles` int(11) NOT NULL,
  `Rol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Roles`
--

INSERT INTO `Roles` (`idRoles`, `Rol`) VALUES
(5, 'ADMINISTRADOR'),
(6, 'Control');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Sucursales`
--

CREATE TABLE `Sucursales` (
  `SucursalId` int(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Direccion` text NOT NULL,
  `Telefono` text NOT NULL,
  `Correo` text NOT NULL,
  `Parroquia` text NOT NULL,
  `Canton` text NOT NULL,
  `Provincia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Sucursales`
--

INSERT INTO `Sucursales` (`SucursalId`, `Nombre`, `Direccion`, `Telefono`, `Correo`, `Parroquia`, `Canton`, `Provincia`) VALUES
(5, 'Ambato', 'UNIANDES', '0987654321', 'correo@gmail.com', 'San Antonio', 'Ambato', 'Tungurahua'),
(6, 'Salasaca', 'Salasaca', '0987654321', 'correosalasaca@gmail.com', 'Salasaca', 'Pelileo', 'Tungurahua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tipo_Acceso`
--

CREATE TABLE `Tipo_Acceso` (
  `IdTipoAcceso` int(11) NOT NULL,
  `Detalle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Tipo_Acceso`
--

INSERT INTO `Tipo_Acceso` (`IdTipoAcceso`, `Detalle`) VALUES
(1, 'Ingreso'),
(2, 'Salida'),
(3, 'Ingreso Almuerzo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `idUsuarios` int(11) NOT NULL,
  `Nombres` varchar(45) NOT NULL,
  `Apellidos` text NOT NULL,
  `contrasenia` varchar(45) NOT NULL,
  `Correo` varchar(45) NOT NULL,
  `SucursalId` int(11) DEFAULT NULL,
  `Cedula` varchar(17) NOT NULL,
  `imagen` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`idUsuarios`, `Nombres`, `Apellidos`, `contrasenia`, `Correo`, `SucursalId`, `Cedula`, `imagen`) VALUES
(3, 'Luis', 'Llerena', '123', 'correo@gmail.com', 5, '1803971371', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios_Roles`
--

CREATE TABLE `Usuarios_Roles` (
  `Usuarios_idUsuarios` int(11) NOT NULL,
  `Roles_idRoles` int(11) NOT NULL,
  `idUsuariosRoles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Usuarios_Roles`
--

INSERT INTO `Usuarios_Roles` (`Usuarios_idUsuarios`, `Roles_idRoles`, `idUsuariosRoles`) VALUES
(3, 5, 16);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Accesos`
--
ALTER TABLE `Accesos`
  ADD PRIMARY KEY (`idAccesos`),
  ADD KEY `fk_Accesos_Usuarios1_idx` (`Usuarios_idUsuarios`),
  ADD KEY `Acceso_tipoAcceso` (`IdTipoAcceso`),
  ADD KEY `Accesos_Empleado` (`EmpleadoId`);

--
-- Indices de la tabla `Empleado`
--
ALTER TABLE `Empleado`
  ADD PRIMARY KEY (`EmpleadoId`),
  ADD KEY `empleado_sucursal` (`SucursalId`),
  ADD KEY `empleado_rol` (`RolId`);

--
-- Indices de la tabla `Faltas`
--
ALTER TABLE `Faltas`
  ADD PRIMARY KEY (`FaltaId`),
  ADD KEY `Falta_Empleado` (`EmpleadoId`);

--
-- Indices de la tabla `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`idRoles`);

--
-- Indices de la tabla `Sucursales`
--
ALTER TABLE `Sucursales`
  ADD PRIMARY KEY (`SucursalId`);

--
-- Indices de la tabla `Tipo_Acceso`
--
ALTER TABLE `Tipo_Acceso`
  ADD PRIMARY KEY (`IdTipoAcceso`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`idUsuarios`),
  ADD KEY `Usuarios_Sucursales` (`SucursalId`);

--
-- Indices de la tabla `Usuarios_Roles`
--
ALTER TABLE `Usuarios_Roles`
  ADD PRIMARY KEY (`idUsuariosRoles`),
  ADD KEY `fk_Usuarios_has_Roles_Roles1_idx` (`Roles_idRoles`),
  ADD KEY `fk_Usuarios_has_Roles_Usuarios1_idx` (`Usuarios_idUsuarios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Accesos`
--
ALTER TABLE `Accesos`
  MODIFY `idAccesos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `Empleado`
--
ALTER TABLE `Empleado`
  MODIFY `EmpleadoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `Faltas`
--
ALTER TABLE `Faltas`
  MODIFY `FaltaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `Roles`
--
ALTER TABLE `Roles`
  MODIFY `idRoles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `Sucursales`
--
ALTER TABLE `Sucursales`
  MODIFY `SucursalId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `Tipo_Acceso`
--
ALTER TABLE `Tipo_Acceso`
  MODIFY `IdTipoAcceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Usuarios_Roles`
--
ALTER TABLE `Usuarios_Roles`
  MODIFY `idUsuariosRoles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Accesos`
--
ALTER TABLE `Accesos`
  ADD CONSTRAINT `Acceso_tipoAcceso` FOREIGN KEY (`IdTipoAcceso`) REFERENCES `Tipo_Acceso` (`IdTipoAcceso`),
  ADD CONSTRAINT `Accesos_Empleado` FOREIGN KEY (`EmpleadoId`) REFERENCES `Empleado` (`EmpleadoId`),
  ADD CONSTRAINT `fk_Accesos_Usuarios1` FOREIGN KEY (`Usuarios_idUsuarios`) REFERENCES `Usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `Empleado`
--
ALTER TABLE `Empleado`
  ADD CONSTRAINT `empleado_rol` FOREIGN KEY (`RolId`) REFERENCES `Roles` (`idRoles`),
  ADD CONSTRAINT `empleado_sucursal` FOREIGN KEY (`SucursalId`) REFERENCES `Sucursales` (`SucursalId`);

--
-- Filtros para la tabla `Faltas`
--
ALTER TABLE `Faltas`
  ADD CONSTRAINT `Falta_Empleado` FOREIGN KEY (`EmpleadoId`) REFERENCES `Empleado` (`EmpleadoId`);

--
-- Filtros para la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD CONSTRAINT `Usuarios_Sucursales` FOREIGN KEY (`SucursalId`) REFERENCES `Sucursales` (`SucursalId`);

--
-- Filtros para la tabla `Usuarios_Roles`
--
ALTER TABLE `Usuarios_Roles`
  ADD CONSTRAINT `fk_Usuarios_has_Roles_Roles1` FOREIGN KEY (`Roles_idRoles`) REFERENCES `Roles` (`idRoles`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Usuarios_has_Roles_Usuarios1` FOREIGN KEY (`Usuarios_idUsuarios`) REFERENCES `Usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

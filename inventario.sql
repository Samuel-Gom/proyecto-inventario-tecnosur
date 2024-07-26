-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-07-2024 a las 20:48:11
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `IdCompra` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `NroDoc` varchar(15) NOT NULL,
  `Proveedor` varchar(200) NOT NULL,
  `RucProveedor` varchar(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `compra`
--
DELIMITER $$
CREATE TRIGGER `editar_producto_compra` AFTER UPDATE ON `compra` FOR EACH ROW BEGIN
    -- Primera Condición: Si cambian tanto la cantidad como el ID del producto
    IF NEW.Cantidad != OLD.Cantidad AND NEW.IdProducto != OLD.IdProducto THEN
        UPDATE producto
        SET Cantidad = Cantidad - OLD.Cantidad
        WHERE IdProducto = OLD.IdProducto;
        
        UPDATE producto
        SET Cantidad = Cantidad + NEW.Cantidad
        WHERE IdProducto = NEW.IdProducto;

    -- Segunda Condición: Si solo cambia la cantidad
    ELSEIF NEW.Cantidad != OLD.Cantidad AND NEW.IdProducto = OLD.IdProducto THEN
        UPDATE producto
        SET Cantidad = (Cantidad - OLD.Cantidad) + NEW.Cantidad
        WHERE IdProducto = NEW.IdProducto;

    -- Tercera Condición: Si solo cambia el ID del producto
    ELSEIF NEW.Cantidad = OLD.Cantidad AND NEW.IdProducto != OLD.IdProducto THEN
        UPDATE producto
        SET Cantidad = Cantidad - OLD.Cantidad
        WHERE IdProducto = OLD.IdProducto;
        
        UPDATE producto
        SET Cantidad = Cantidad + NEW.Cantidad
        WHERE IdProducto = NEW.IdProducto;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sumar_cantidad_producto` AFTER INSERT ON `compra` FOR EACH ROW BEGIN
    UPDATE producto
    SET Cantidad = Cantidad + NEW.Cantidad
    WHERE IdProducto = NEW.IdProducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `IdLogin` int(11) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `Nombres` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`IdLogin`, `Usuario`, `Password`, `Apellidos`, `Nombres`) VALUES
(1, 'admin', 'admin', 'Gomez', 'Samuel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `IdProducto` int(11) NOT NULL,
  `NombreProducto` varchar(200) NOT NULL,
  `Cantidad` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`IdProducto`, `NombreProducto`, `Cantidad`) VALUES
(1, 'Arroz', 0),
(2, 'Harina', 0),
(3, 'Leche', 0),
(4, 'Maiz', 0),
(5, 'Fideo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `IdVenta` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `NroDoc` varchar(15) NOT NULL,
  `Cliente` varchar(200) NOT NULL,
  `Ruc` varchar(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `venta`
--
DELIMITER $$
CREATE TRIGGER `editar_producto_venta` AFTER UPDATE ON `venta` FOR EACH ROW BEGIN
    -- Primera Condición: Si cambian tanto la cantidad como el ID del producto
    IF NEW.Cantidad != OLD.Cantidad AND NEW.IdProducto != OLD.IdProducto THEN
        UPDATE producto
        SET Cantidad = Cantidad + OLD.Cantidad
        WHERE IdProducto = OLD.IdProducto;
        
        UPDATE producto
        SET Cantidad = Cantidad - NEW.Cantidad
        WHERE IdProducto = NEW.IdProducto;

    -- Segunda Condición: Si solo cambia la cantidad
    ELSEIF NEW.Cantidad != OLD.Cantidad AND NEW.IdProducto = OLD.IdProducto THEN
        UPDATE producto
        SET Cantidad = (Cantidad + OLD.Cantidad) - NEW.Cantidad
        WHERE IdProducto = NEW.IdProducto;

    -- Tercera Condición: Si solo cambia el ID del producto
    ELSEIF NEW.Cantidad = OLD.Cantidad AND NEW.IdProducto != OLD.IdProducto THEN
        UPDATE producto
        SET Cantidad = Cantidad + OLD.Cantidad
        WHERE IdProducto = OLD.IdProducto;
        
        UPDATE producto
        SET Cantidad = Cantidad - NEW.Cantidad
        WHERE IdProducto = NEW.IdProducto;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `restar_cantidad_producto` AFTER INSERT ON `venta` FOR EACH ROW BEGIN
    UPDATE producto
    SET Cantidad = Cantidad - NEW.Cantidad
    WHERE IdProducto = NEW.IdProducto;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`IdCompra`),
  ADD KEY `fk_producto1t` (`IdProducto`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`IdLogin`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IdProducto`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `fk_producto2` (`IdProducto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `IdCompra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `IdLogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `IdProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `IdVenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_producto1t` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_producto2` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`IdProducto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
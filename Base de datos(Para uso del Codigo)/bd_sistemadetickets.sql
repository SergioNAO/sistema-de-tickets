-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-01-2024 a las 22:24:38
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
-- Base de datos: `bd_sistemadetickets`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_get_ticket_grafico` ()   BEGIN
SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                        FROM   tm_ticket  JOIN  
                            tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                        WHERE    
                        tm_ticket.estado = 1
                        GROUP BY 
                        tm_categoria.cat_nom 
                        ORDER BY total DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_get_ticket_total` ()   BEGIN
SELECT COUNT(*) AS TOTAL FROM tm_ticket;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_get_ticket_totalabierto` ()   BEGIN
SELECT COUNT(*) AS TOTAL FROM tm_ticket WHERE ticket_estado='Abierto';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_get_ticket_totalcerrado` ()   BEGIN
SELECT COUNT(*) AS TOTAL FROM tm_ticket WHERE ticket_estado='Cerrado';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_insert_ticket` (IN `xusu_id` INT, `xcat_id` INT, `xticket_titulo` VARCHAR(250), `xticket_descripcion` VARCHAR(2000))   BEGIN
INSERT INTO tm_ticket (ticket_id,usu_id,cat_id,ticket_titulo,ticket_descripcion,ticket_estado,fecha_crear,estado) VALUES (NULL,xusu_id,xcat_id,xticket_titulo,xticket_descripcion,'Abierto',now(),'1');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_insert_ticketdetalle` (IN `xticket_id` INT, `xusu_id` INT, `xticketd_descripcion` VARCHAR(1000))   BEGIN
INSERT INTO td_ticketdetalle (ticketd_id, ticket_id, usu_id, ticketd_descripcion, fecha_crear, estado) VALUES (NULL,xticket_id,xusu_id,xticketd_descripcion,now(), '1');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_insert_ticketdetalle_cerrar` (IN `xticket_id` INT, `xusu_id` INT)   BEGIN
INSERT INTO td_ticketdetalle (ticketd_id, ticket_id, usu_id, ticketd_descripcion, fecha_crear, estado) VALUES (NULL,xticket_id,xusu_id,'Ticket Cerrado...',now(), '1');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_listar_ticket` ()   BEGIN
			SELECT
                tm_ticket.ticket_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.ticket_titulo,
                tm_ticket.ticket_descripcion,
                tm_ticket.ticket_estado,
                tm_ticket.fecha_crear,
                tm_usuarios.usu_nom,
                tm_usuarios.usu_ape,
                tm_categoria.cat_nom
                FROM
                tm_ticket
                INNER JOIN tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER JOIN tm_usuarios on tm_ticket.usu_id = tm_usuarios.usu_id
                WHERE
                tm_ticket.estado = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_listar_ticketdetalle_x_ticket` (IN `xticket_id` INT)   BEGIN
			SELECT 
                td_ticketdetalle.ticketd_id,
                td_ticketdetalle.ticketd_descripcion,
                td_ticketdetalle.fecha_crear,
                tm_usuarios.usu_nom,
                tm_usuarios.usu_ape,
                tm_usuarios.rol_id
                FROM 
                td_ticketdetalle 
                INNER JOIN tm_usuarios on td_ticketdetalle.usu_id = tm_usuarios.usu_id
                WHERE 
                ticket_id = xticket_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_listar_ticket_x_id` (IN `xticket_id` INT)   BEGIN
			SELECT 
                tm_ticket.ticket_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.ticket_titulo,
                tm_ticket.ticket_descripcion,
                tm_ticket.ticket_estado,
                tm_ticket.fecha_crear,
                tm_usuarios.usu_nom,
                tm_usuarios.usu_ape,
                tm_usuarios.usu_correo,
                tm_categoria.cat_nom
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuarios on tm_ticket.usu_id = tm_usuarios.usu_id
                WHERE
                tm_ticket.estado = 1
                AND tm_ticket.ticket_id = xticket_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_listar_ticket_x_usu` (IN `xusu_id` INT)   BEGIN
		SELECT
                tm_ticket.ticket_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.ticket_titulo,
                tm_ticket.ticket_descripcion,
                tm_ticket.ticket_estado,
                tm_ticket.fecha_crear,
                tm_usuarios.usu_nom,
                tm_usuarios.usu_ape,
                tm_categoria.cat_nom
                FROM
                tm_ticket
                INNER JOIN tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER JOIN tm_usuarios on tm_ticket.usu_id = tm_usuarios.usu_id
                WHERE
                tm_ticket.estado = 1
                AND tm_usuarios.usu_id=xusu_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Ticket_update_ticket` (IN `xticket_id` INT)   BEGIN
UPDATE tm_ticket
                    SET
                        ticket_estado = 'Cerrado'
                    WHERE
                        ticket_id = xticket_id; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tm_categoria_get_categoria` ()   BEGIN
	SELECT * FROM tm_categoria WHERE estado=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_delete_usuario` (IN `xusu_id` INT)   BEGIN
	UPDATE tm_usuarios SET estado='0' , fecha_eliminacion = now() WHERE usu_id=xusu_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_get_usuario` ()   BEGIN
		SELECT * FROM tm_usuarios WHERE estado='1';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_get_usuario_grafico` (IN `xusu_id` INT)   BEGIN
				SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                        FROM   tm_ticket  JOIN  
                            tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                        WHERE    
                        tm_ticket.estado = 1
                        AND tm_ticket.usu_id = xusu_id
                        GROUP BY 
                        tm_categoria.cat_nom 
                        ORDER BY total DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_get_usuario_totalabierto_x_id` (IN `xusu_id` INT)   BEGIN
SELECT COUNT(*) AS TOTAL FROM tm_ticket WHERE usu_id=xusu_id and ticket_estado='Abierto';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_get_usuario_totalcerrado_x_id` (IN `xusu_id` INT)   BEGIN
SELECT COUNT(*) AS TOTAL FROM tm_ticket WHERE usu_id=xusu_id and ticket_estado='Cerrado';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_get_usuario_total_x_id` (IN `xusu_id` INT)   BEGIN
	SELECT COUNT(*) AS TOTAL FROM tm_ticket WHERE usu_id = xusu_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_get_usuario_x_id` (IN `xusu_id` INT)   BEGIN
	SELECT * FROM tm_usuarios WHERE usu_id=xusu_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_insert_usuario` (IN `xusu_nom` VARCHAR(150), `xusu_ape` VARCHAR(150), `xusu_correo` VARCHAR(150), `xusu_pass` VARCHAR(50), `xrol_id` INT)   BEGIN
	INSERT INTO tm_usuarios 
    (usu_id,usu_nom,usu_ape,usu_correo,usu_pass,rol_id,fecha_crea,fecha_modificacion,fecha_eliminacion,estado) 
    VALUES (NULL,xusu_nom,xusu_ape,xusu_correo,xusu_pass,xrol_id,now(), NULL, NULL, '1');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_login` (IN `xusu_correo` VARCHAR(150), `xusu_pass` VARCHAR(50), `xrol_id` INT)   BEGIN
	SELECT * FROM tm_usuarios WHERE usu_correo = xusu_correo and usu_pass = xusu_pass and rol_id = xrol_id and estado =1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Usuario_update_usuario` (IN `xusu_nom` VARCHAR(150), `xusu_ape` VARCHAR(150), `xusu_correo` VARCHAR(150), `xusu_pass` VARCHAR(50), `xrol_id` INT, `xusu_id` INT)   BEGIN
	UPDATE tm_usuarios SET
                        usu_nom = xusu_nom,
                        usu_ape = xusu_ape,
                        usu_correo = xusu_correo, 
                        usu_pass = xusu_pass,
                        rol_id = xrol_id
                        WHERE
                        usu_id = xusu_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_documento`
--

CREATE TABLE `td_documento` (
  `doc_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `doc_nom` varchar(400) NOT NULL,
  `fecha_crea` datetime NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `td_ticketdetalle`
--

CREATE TABLE `td_ticketdetalle` (
  `ticketd_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `usu_id` int(11) NOT NULL,
  `ticketd_descripcion` mediumtext NOT NULL,
  `fecha_crear` datetime NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_categoria`
--

CREATE TABLE `tm_categoria` (
  `cat_id` int(11) NOT NULL,
  `cat_nom` varchar(150) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tm_categoria`
--

INSERT INTO `tm_categoria` (`cat_id`, `cat_nom`, `estado`) VALUES
(1, 'Hardware', 1),
(2, 'Software', 1),
(3, 'Otros', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_ticket`
--

CREATE TABLE `tm_ticket` (
  `ticket_id` int(11) NOT NULL,
  `usu_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `ticket_titulo` varchar(250) NOT NULL,
  `ticket_descripcion` varchar(2000) NOT NULL,
  `ticket_estado` varchar(15) DEFAULT NULL,
  `fecha_crear` datetime DEFAULT NULL,
  `usuario_asignado` int(11) DEFAULT NULL,
  `fecha_asignacion` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tm_usuarios`
--

CREATE TABLE `tm_usuarios` (
  `usu_id` int(11) NOT NULL,
  `usu_nom` varchar(150) DEFAULT NULL,
  `usu_ape` varchar(150) DEFAULT NULL,
  `usu_correo` varchar(150) NOT NULL,
  `usu_pass` varchar(150) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_eliminacion` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla Mantenedor de Usuarios';

--
-- Volcado de datos para la tabla `tm_usuarios`
--

INSERT INTO `tm_usuarios` (`usu_id`, `usu_nom`, `usu_ape`, `usu_correo`, `usu_pass`, `rol_id`, `fecha_crea`, `fecha_modificacion`, `fecha_eliminacion`, `estado`) VALUES
(24, 'Soporte', 'Apellido', 'mail@mail.com', '123456', 1, '2023-11-21 15:35:20', NULL, NULL, 1),
(25, 'Usuario', 'Ape', 'usumail@mail.com', '123456', 2, '2023-11-21 15:35:20', NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `td_documento`
--
ALTER TABLE `td_documento`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indices de la tabla `td_ticketdetalle`
--
ALTER TABLE `td_ticketdetalle`
  ADD PRIMARY KEY (`ticketd_id`);

--
-- Indices de la tabla `tm_categoria`
--
ALTER TABLE `tm_categoria`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `tm_ticket`
--
ALTER TABLE `tm_ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indices de la tabla `tm_usuarios`
--
ALTER TABLE `tm_usuarios`
  ADD PRIMARY KEY (`usu_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `td_documento`
--
ALTER TABLE `td_documento`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `td_ticketdetalle`
--
ALTER TABLE `td_ticketdetalle`
  MODIFY `ticketd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `tm_categoria`
--
ALTER TABLE `tm_categoria`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tm_ticket`
--
ALTER TABLE `tm_ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT de la tabla `tm_usuarios`
--
ALTER TABLE `tm_usuarios`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2024 a las 01:07:30
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
-- Base de datos: `incidencias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

CREATE TABLE `aulas` (
  `id_aula` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `id_edificio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aulas`
--

INSERT INTO `aulas` (`id_aula`, `nombre`, `id_edificio`) VALUES
(1, 'Aula 101', 1),
(2, 'Aula 102', 1),
(3, 'Aula 201', 2),
(4, 'Aula 202', 2),
(5, 'Aula 301', 3),
(6, 'Aula 302', 3),
(7, 'Aula 401', 4),
(8, 'Aula 402', 4),
(9, 'Aula 501', 5),
(10, 'Aula 502', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id_cotizacion` int(11) NOT NULL,
  `id_incidencia` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','aprobada','rechazada') DEFAULT 'pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id_cotizacion`, `id_incidencia`, `descripcion`, `costo`, `estado`, `fecha_creacion`) VALUES
(1, 1, 'Cambio de fuente de poder', 850.00, 'aprobada', '2024-12-09 06:33:16'),
(2, 2, 'Reemplazo de cable HDMI', 150.00, 'rechazada', '2024-12-09 06:33:16'),
(3, 5, 'Disco Duro', 700.00, 'rechazada', '2024-12-09 15:57:45'),
(4, 5, 'memoria ram 8gb', 500.00, 'aprobada', '2024-12-10 18:05:30'),
(5, 7, 'Fuente de poder', 500.00, 'aprobada', '2024-12-10 19:15:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `jefe_departamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `nombre`, `jefe_departamento`) VALUES
(1, 'Sistemas', 3),
(2, 'Administración', 4),
(3, 'Redes', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_computadora`
--

CREATE TABLE `detalles_computadora` (
  `id_equipo` int(11) NOT NULL,
  `procesador` varchar(100) DEFAULT NULL,
  `ram` varchar(50) DEFAULT NULL,
  `almacenamiento` varchar(50) DEFAULT NULL,
  `tarjeta_grafica` varchar(100) DEFAULT NULL,
  `sistema_operativo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_computadora`
--

INSERT INTO `detalles_computadora` (`id_equipo`, `procesador`, `ram`, `almacenamiento`, `tarjeta_grafica`, `sistema_operativo`) VALUES
(1, 'Intel Core i5', '8GB DDR4', '256GB SSD', 'Integrada', 'Windows 10 Pro'),
(8, 'Intel Core i7', '16GB DDR4', '512GB SSD', 'Intel UHD Graphics', 'Windows 10 Pro'),
(9, 'Intel Core i5', '8GB DDR4', '512GB SSD', 'Intel Iris Xe', 'Windows 10 Pro'),
(10, 'Intel Core i9', '32GB DDR4', '1TB SSD', 'NVIDIA GeForce RTX 3070', 'Windows 10 Pro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_monitor`
--

CREATE TABLE `detalles_monitor` (
  `id_equipo` int(11) NOT NULL,
  `tamano` varchar(50) DEFAULT NULL,
  `resolucion` varchar(50) DEFAULT NULL,
  `tipo_panel` varchar(50) DEFAULT NULL,
  `frecuencia_refresco` varchar(50) DEFAULT NULL,
  `puertos` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_monitor`
--

INSERT INTO `detalles_monitor` (`id_equipo`, `tamano`, `resolucion`, `tipo_panel`, `frecuencia_refresco`, `puertos`) VALUES
(3, '24 pulgadas', '1920x1080', 'IPS', '75Hz', 'HDMI, DisplayPort'),
(13, '27 pulgadas', '2560x1440', 'IPS', '75Hz', 'HDMI, DisplayPort, VGA'),
(14, '24 pulgadas', '1920x1080', 'IPS', '60Hz', 'HDMI, DisplayPort');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_periferico`
--

CREATE TABLE `detalles_periferico` (
  `id_equipo` int(11) NOT NULL,
  `tipo_periferico` enum('teclado','raton','impresora','otro') NOT NULL,
  `conexion` enum('cable','inalambrico') DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `especificaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_periferico`
--

INSERT INTO `detalles_periferico` (`id_equipo`, `tipo_periferico`, `conexion`, `marca`, `modelo`, `especificaciones`) VALUES
(4, 'teclado', 'inalambrico', 'Logitech', 'K270', 'Conexión USB inalámbrica'),
(15, 'teclado', 'cable', 'Razer', 'Huntsman Elite', 'Teclado mecánico con retroiluminación RGB y switches ópticos'),
(16, 'raton', 'cable', 'Logitech', 'G502 HERO', 'Ratón ergonómico con 16,000 DPI y 11 botones programables');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_proyector`
--

CREATE TABLE `detalles_proyector` (
  `id_equipo` int(11) NOT NULL,
  `resolucion` varchar(50) DEFAULT NULL,
  `brillo` varchar(50) DEFAULT NULL,
  `tipo_lampara` varchar(50) DEFAULT NULL,
  `vida_util_lampara` varchar(50) DEFAULT NULL,
  `conectividad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_proyector`
--

INSERT INTO `detalles_proyector` (`id_equipo`, `resolucion`, `brillo`, `tipo_lampara`, `vida_util_lampara`, `conectividad`) VALUES
(2, '1920x1080', '3000 lúmenes', 'LED', '5000 horas', 'HDMI, VGA'),
(11, '1280x800', '3500 lúmenes', 'Lámpara UHE', '5000 horas', 'HDMI, VGA'),
(12, '1280x800', '3600 lúmenes', 'Lámpara UHE', '5000 horas', 'HDMI, VGA, USB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_red`
--

CREATE TABLE `detalles_red` (
  `id_equipo` int(11) NOT NULL,
  `tipo_dispositivo` enum('router','switch','punto_acceso','otro') NOT NULL,
  `puertos` int(11) DEFAULT NULL,
  `velocidad` varchar(50) DEFAULT NULL,
  `soporte_protocolos` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_red`
--

INSERT INTO `detalles_red` (`id_equipo`, `tipo_dispositivo`, `puertos`, `velocidad`, `soporte_protocolos`) VALUES
(5, 'switch', 8, '1Gbps', '802.3ab, 802.3u, 802.3x');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificios`
--

CREATE TABLE `edificios` (
  `id_edificio` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `id_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `edificios`
--

INSERT INTO `edificios` (`id_edificio`, `nombre`, `id_departamento`) VALUES
(1, 'Edificio A', 1),
(2, 'Edificio B', 1),
(3, 'Edificio C', 1),
(4, 'Edificio D', 2),
(5, 'Edificio E', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL,
  `tipo` enum('computadora','proyector','monitor','periférico','red','otro') NOT NULL,
  `descripcion` text DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `numero_serie` varchar(100) DEFAULT NULL,
  `fecha_adquisicion` date DEFAULT NULL,
  `garantia` date DEFAULT NULL,
  `estado` enum('funcional','en_reparacion','fuera_de_servicio') DEFAULT 'funcional',
  `id_aula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `tipo`, `descripcion`, `modelo`, `numero_serie`, `fecha_adquisicion`, `garantia`, `estado`, `id_aula`) VALUES
(1, 'computadora', 'PC para oficina', 'Dell OptiPlex 3080', 'SN12345', '2023-01-15', '2025-01-15', 'funcional', 1),
(2, 'proyector', 'Proyector LED', 'Epson EX5260', 'SN54321', '2022-06-10', '2024-06-10', 'funcional', 1),
(3, 'monitor', 'Monitor IPS Full HD', 'HP 24mh', 'SN23456', '2023-03-20', '2025-03-20', 'funcional', 3),
(4, 'periférico', 'Teclado inalámbrico', 'Logitech K270', 'SN34567', '2022-12-05', '2024-12-05', 'funcional', 4),
(5, 'red', 'Switch Gigabit', 'TP-Link TL-SG108', 'SN45678', '2023-08-01', '2026-08-01', 'funcional', 5),
(6, 'computadora', 'Computadora de escritorio HP', 'HP EliteDesk 800 G5', 'SN123456789', '2023-01-15', '2025-01-15', 'funcional', 1),
(7, 'computadora', 'Laptop Lenovo ThinkPad X1 Carbon', 'ThinkPad X1 Carbon 9', 'SN987654321', '2023-03-20', '2025-03-20', 'funcional', 2),
(8, 'computadora', 'Computadora de escritorio Dell OptiPlex 7080', 'OptiPlex 7080', 'SN123456780', '2023-07-10', '2025-07-10', 'funcional', 1),
(9, 'computadora', 'Laptop ASUS ZenBook UX425', 'ZenBook UX425', 'SN123456781', '2023-08-15', '2025-08-15', 'funcional', 1),
(10, 'computadora', 'PC de escritorio Acer Predator Orion 5000', 'Orion 5000', 'SN123456782', '2023-09-01', '2025-09-01', 'funcional', 1),
(11, 'proyector', 'Proyector BenQ MW535', 'MW535', 'PJN123456790', '2023-10-05', '2025-10-05', 'funcional', 1),
(12, 'proyector', 'Proyector ViewSonic PA503W', 'PA503W', 'PJN123456791', '2023-11-20', '2025-11-20', 'funcional', 1),
(13, 'monitor', 'Monitor ASUS ProArt PA278QV', 'PA278QV', 'MON123456790', '2023-06-15', '2025-06-15', 'funcional', 1),
(14, 'monitor', 'Monitor Dell P2419H', 'P2419H', 'MON123456791', '2023-07-01', '2025-07-01', 'funcional', 1),
(15, 'periférico', 'Teclado mecánico Razer Huntsman Elite', 'Huntsman Elite', 'PFE123456790', '2023-12-01', '2025-12-01', 'funcional', 1),
(16, 'periférico', 'Ratón Logitech G502 HERO', 'G502 HERO', 'MOU987654322', '2023-12-01', '2025-12-01', 'funcional', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos_muchas_incidencias`
--

CREATE TABLE `equipos_muchas_incidencias` (
  `id` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `num_incidencias` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos_muchas_incidencias`
--

INSERT INTO `equipos_muchas_incidencias` (`id`, `id_equipo`, `num_incidencias`, `id_tecnico`, `fecha_registro`, `comentario`) VALUES
(1, 1, 3, 2, '2024-12-10 19:03:16', NULL),
(2, 2, 1, 2, '2024-12-10 19:42:00', 'lote con mismo problema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE `evaluaciones` (
  `id_evaluacion` int(11) NOT NULL,
  `id_incidencia` int(11) NOT NULL,
  `id_jefe` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL CHECK (`calificacion` between 1 and 5),
  `comentarios` text DEFAULT NULL,
  `fecha_evaluacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evaluaciones`
--

INSERT INTO `evaluaciones` (`id_evaluacion`, `id_incidencia`, `id_jefe`, `calificacion`, `comentarios`, `fecha_evaluacion`) VALUES
(1, 1, 3, 4, 'El técnico fue eficiente y rápido.', '2024-12-09 06:33:23'),
(2, 2, 3, 5, 'Reparación impecable.', '2024-12-09 06:33:23'),
(3, 1, 2, 5, 'Se corrigio el problema y el equipo funciono correctamente', '2024-12-09 15:39:21'),
(4, 1, 2, 5, 'bien', '2024-12-10 18:03:36'),
(5, 5, 2, 5, 'bien', '2024-12-10 19:21:02'),
(6, 7, 2, 5, 'bien', '2024-12-10 19:21:19'),
(7, 8, 2, 5, 'exelente servicio', '2024-12-10 19:28:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencias`
--

CREATE TABLE `incidencias` (
  `id_incidencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `id_tecnico` int(11) DEFAULT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `prioridad` enum('baja','media','alta','critica') NOT NULL,
  `estado` enum('abierta','en_progreso','en_taller','cerrada') DEFAULT 'abierta',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incidencias`
--

INSERT INTO `incidencias` (`id_incidencia`, `id_usuario`, `id_equipo`, `id_tecnico`, `titulo`, `descripcion`, `prioridad`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 4, 1, 2, 'PC no enciende', 'La computadora de la oficina 101 no arranca.\n\nAvance: SE LLEVO EQUIPO A TALLER PARA REVISAR LA FUENTE\n\nAvance: SE CAMBIARA LA FUENTE DE PODER \n\nAvance: SE CAMBIARA LA FUENTE DE PODER \n\nAvance: SE REVISA EL EQUIIPO\n\nAvance: SE REALIZA CAMBIO DE FUENTE DE PODER \n\nAvance: SE REALIZA CAMBIO DE FUENTE DE PODER \n\nAvance: encendio y persistio encendida despues de el cambio', 'alta', 'cerrada', '2024-12-09 06:33:08', '2024-12-09 15:34:50'),
(2, 4, 2, 2, 'Proyector sin señal', 'El proyector del aula 102 no proyecta la imagen.', 'media', 'en_progreso', '2024-12-09 06:33:08', '2024-12-09 14:58:54'),
(4, 3, 1, 2, '', 'lenta se traba mucho', 'media', 'abierta', '2024-12-09 14:50:57', '2024-12-10 17:53:09'),
(5, 3, 1, 2, 'Equipo Lento', 'Se traba al abrir los programas\n\nAvance: se le aumentara la memoria ram\n\nAvance: se le puso mas ram', 'media', 'cerrada', '2024-12-09 14:58:16', '2024-12-10 19:20:25'),
(6, 3, 1, 2, 'Equipo Lento', 'se traba mucho al abrir aplicaciones ', 'media', 'en_progreso', '2024-12-10 18:04:26', '2024-12-10 18:04:40'),
(7, 3, 1, 2, 'Equipo Lento', 'No enciende \n\nAvance: No funciona la fuente de poder\n\nAvance: se realizo cambio y ya encendio', 'alta', 'cerrada', '2024-12-10 19:14:37', '2024-12-10 19:20:45'),
(8, 3, 1, 2, 'No sistema', 'El equipo no tiene sistema operativo\n\nAvance: se le instalo sistema operativo', 'media', 'cerrada', '2024-12-10 19:26:46', '2024-12-10 19:27:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia_servicio`
--

CREATE TABLE `incidencia_servicio` (
  `id_incidencia` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre_permiso` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre_permiso`) VALUES
(1, 'iniciar_sesion'),
(2, 'cerrar_sesion'),
(3, 'cambiar_contrasena'),
(4, 'crear_usuarios'),
(5, 'editar_usuarios'),
(6, 'bloquear_usuarios'),
(7, 'registrar_incidencias'),
(8, 'asignar_incidencias'),
(9, 'actualizar_incidencias'),
(10, 'consultar_incidencias'),
(11, 'generar_reportes'),
(12, 'configuracion_sistema'),
(13, 'consultar_logs'),
(14, 'recibir_notificaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` enum('administrador','tecnico','jefe_departamento','usuario_final') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'administrador'),
(2, 'tecnico'),
(3, 'jefe_departamento'),
(4, 'usuario_final');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

CREATE TABLE `rol_permiso` (
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_permiso`
--

INSERT INTO `rol_permiso` (`id_rol`, `id_permiso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(2, 1),
(2, 2),
(2, 3),
(2, 9),
(2, 10),
(2, 14),
(3, 1),
(3, 2),
(3, 3),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 12),
(3, 14),
(4, 1),
(4, 2),
(4, 3),
(4, 7),
(4, 10),
(4, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombre_servicio` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo_equipo` enum('computadora','proyector','monitor','periférico','red','otro') NOT NULL,
  `complejidad` enum('baja','media','alta','crítica') NOT NULL,
  `tiempo_estimado` int(11) NOT NULL,
  `costo_estimado` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`, `descripcion`, `tipo_equipo`, `complejidad`, `tiempo_estimado`, `costo_estimado`) VALUES
(1, 'Reinstalar Sistema Operativo', 'Reinstalación completa del sistema operativo.', 'computadora', 'alta', 120, 500.00),
(2, 'Cambio de RAM', 'Reemplazo de módulo de memoria RAM.', 'computadora', 'media', 30, 200.00),
(3, 'Calibrar Proyector', 'Ajustes de enfoque, resolución y brillo.', 'proyector', 'media', 45, 300.00),
(4, 'Cambio de Fuente de Alimentación', 'Sustitución de la fuente de alimentación del equipo.', 'computadora', 'alta', 60, 400.00),
(5, 'Revisión de Conexión de Red', 'Diagnóstico y reparación de la conexión a la red.', 'red', 'baja', 20, 150.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `tipo_usuario` enum('administrador','tecnico','jefe_departamento','usuario_final') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `contrasena`, `tipo_usuario`) VALUES
(1, 'Juan Pérez', 'juan@example.com', 'password123', 'administrador'),
(2, 'Carlos López', 'carlos@example.com', 'password123', 'tecnico'),
(3, 'Ana García', 'ana@example.com', 'password123', 'jefe_departamento'),
(4, 'Pedro Díaz', 'pedro@example.com', 'password123', 'jefe_departamento');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id_aula`),
  ADD KEY `id_edificio` (`id_edificio`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id_cotizacion`),
  ADD KEY `id_incidencia` (`id_incidencia`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`),
  ADD KEY `jefe_departamento` (`jefe_departamento`);

--
-- Indices de la tabla `detalles_computadora`
--
ALTER TABLE `detalles_computadora`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `detalles_monitor`
--
ALTER TABLE `detalles_monitor`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `detalles_periferico`
--
ALTER TABLE `detalles_periferico`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `detalles_proyector`
--
ALTER TABLE `detalles_proyector`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `detalles_red`
--
ALTER TABLE `detalles_red`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `edificios`
--
ALTER TABLE `edificios`
  ADD PRIMARY KEY (`id_edificio`),
  ADD KEY `id_departamento` (`id_departamento`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `id_aula` (`id_aula`);

--
-- Indices de la tabla `equipos_muchas_incidencias`
--
ALTER TABLE `equipos_muchas_incidencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_equipo` (`id_equipo`),
  ADD KEY `id_tecnico` (`id_tecnico`);

--
-- Indices de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  ADD PRIMARY KEY (`id_evaluacion`),
  ADD KEY `id_incidencia` (`id_incidencia`),
  ADD KEY `id_jefe` (`id_jefe`);

--
-- Indices de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_equipo` (`id_equipo`),
  ADD KEY `id_tecnico` (`id_tecnico`);

--
-- Indices de la tabla `incidencia_servicio`
--
ALTER TABLE `incidencia_servicio`
  ADD PRIMARY KEY (`id_incidencia`,`id_servicio`),
  ADD KEY `id_servicio` (`id_servicio`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`id_rol`,`id_permiso`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id_aula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id_cotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `edificios`
--
ALTER TABLE `edificios`
  MODIFY `id_edificio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `equipos_muchas_incidencias`
--
ALTER TABLE `equipos_muchas_incidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  MODIFY `id_evaluacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD CONSTRAINT `aulas_ibfk_1` FOREIGN KEY (`id_edificio`) REFERENCES `edificios` (`id_edificio`);

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_ibfk_1` FOREIGN KEY (`id_incidencia`) REFERENCES `incidencias` (`id_incidencia`);

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`jefe_departamento`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `detalles_computadora`
--
ALTER TABLE `detalles_computadora`
  ADD CONSTRAINT `detalles_computadora_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `detalles_monitor`
--
ALTER TABLE `detalles_monitor`
  ADD CONSTRAINT `detalles_monitor_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `detalles_periferico`
--
ALTER TABLE `detalles_periferico`
  ADD CONSTRAINT `detalles_periferico_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `detalles_proyector`
--
ALTER TABLE `detalles_proyector`
  ADD CONSTRAINT `detalles_proyector_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `detalles_red`
--
ALTER TABLE `detalles_red`
  ADD CONSTRAINT `detalles_red_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `edificios`
--
ALTER TABLE `edificios`
  ADD CONSTRAINT `edificios_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`);

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`id_aula`) REFERENCES `aulas` (`id_aula`);

--
-- Filtros para la tabla `equipos_muchas_incidencias`
--
ALTER TABLE `equipos_muchas_incidencias`
  ADD CONSTRAINT `equipos_muchas_incidencias_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`),
  ADD CONSTRAINT `equipos_muchas_incidencias_ibfk_2` FOREIGN KEY (`id_tecnico`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `evaluaciones`
--
ALTER TABLE `evaluaciones`
  ADD CONSTRAINT `evaluaciones_ibfk_1` FOREIGN KEY (`id_incidencia`) REFERENCES `incidencias` (`id_incidencia`),
  ADD CONSTRAINT `evaluaciones_ibfk_2` FOREIGN KEY (`id_jefe`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD CONSTRAINT `incidencias_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `incidencias_ibfk_2` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`),
  ADD CONSTRAINT `incidencias_ibfk_3` FOREIGN KEY (`id_tecnico`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `incidencia_servicio`
--
ALTER TABLE `incidencia_servicio`
  ADD CONSTRAINT `incidencia_servicio_ibfk_1` FOREIGN KEY (`id_incidencia`) REFERENCES `incidencias` (`id_incidencia`) ON DELETE CASCADE,
  ADD CONSTRAINT `incidencia_servicio_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `rol_permiso_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `rol_permiso_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

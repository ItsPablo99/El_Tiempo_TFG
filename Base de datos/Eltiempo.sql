--
-- Base de datos: eltiempo
--

--
-- Estructura de tabla para la tabla estaciones
--

CREATE TABLE `estaciones` (
  `ID` int(3) NOT NULL,
  `Nombre` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `Ubicacion` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `Cod_seguridad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Estructura de tabla para la tabla registros
--

CREATE TABLE `registros` (
  `ID` int(6) NOT NULL,
  `ID_sensor` int(3) NOT NULL,
  `Temperatura` float NOT NULL,
  `Humedad` float NOT NULL,
  `Fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla estaciones
--
ALTER TABLE `estaciones`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla registros
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `sensor_id` (`ID_sensor`);


--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;


--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `sensor_id` FOREIGN KEY (`ID_sensor`) REFERENCES `estaciones` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION;




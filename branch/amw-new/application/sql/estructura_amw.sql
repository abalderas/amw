-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `parameter` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregables`
--

CREATE TABLE IF NOT EXISTS `entregables` (
  `ent_id` int(11) NOT NULL AUTO_INCREMENT,
  `ent_entregable` varchar(250) NOT NULL,
  `ent_description` varchar(255) NOT NULL,
  PRIMARY KEY (`ent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

CREATE TABLE IF NOT EXISTS `evaluaciones` (
  `eva_id` int(11) NOT NULL AUTO_INCREMENT,
  `eva_user` int(11) NOT NULL,
  `eva_revisor` int(11) NOT NULL,
  `eva_revision` int(11) NOT NULL,
  `eva_time` int(11) NOT NULL,
  PRIMARY KEY (`eva_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones_entregables`
--

CREATE TABLE IF NOT EXISTS `evaluaciones_entregables` (
  `eva_id` int(11) NOT NULL,
  `ent_id` int(11) NOT NULL,
  `ee_nota` int(11) NOT NULL,
  `ee_comentario` varchar(250) NOT NULL,
  PRIMARY KEY (`eva_id`,`ent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_read` int(11) NOT NULL,
  `rep_new` int(11) NOT NULL,
  PRIMARY KEY (`rep_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metaevaluaciones`
--

CREATE TABLE IF NOT EXISTS `metaevaluaciones` (
  `mev_id` int(11) NOT NULL AUTO_INCREMENT,
  `mevaluador_id` int(11) NOT NULL,
  `evaluacion_id` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL,
  `comentario` varchar(250) NOT NULL,
  PRIMARY KEY (`mev_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL UNIQUE,
  `evaluar` boolean NOT NULL DEFAULT true,
  `feedback` boolean NOT NULL DEFAULT true,
  `metaevaluar` boolean NOT NULL DEFAULT false,
  `metaevaluar_lista` boolean NOT NULL DEFAULT false,
  `alumnos` boolean NOT NULL DEFAULT false,
  `parametros` boolean NOT NULL DEFAULT false,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_assignation`
--

CREATE TABLE IF NOT EXISTS `rol_assignation` (
  `user_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Insercion de valores por defecto
--
-- A la vez que creamos la tabla añadimos los dos primeros usuarios, esto ha de hacerse como ultima accion
-- ya que si esta creado dara error y no se crearan las siguientes tablas, y una vez añadidos los usuarios
-- añadimos al primer usuario creado en la wiki como administrador.
-- #TODO evitar esse error

INSERT INTO `roles`(`name`, `evaluar`, `feedback`, `metaevaluar`, `metaevaluar_lista`, `alumnos`, `parametros`)
VALUES ("Admin",1,1,1,1,1,1);
INSERT INTO `roles`(`name`, `evaluar`, `feedback`)  
VALUES ("Student",1,1);
INSERT INTO `rol_assignation`(`user_id`, `rol_id`)
VALUES (1,1);

-- --------------------------------------------------------
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// FICHERO CON OPCIONES DE CONFIGURACIÓN DE ASSESSMEDIAWIKI

// Nombre de la BD de MediaWiki
$config["database_mw"] = "mediawikidb";

// Nombre de usuario de la BD de MediaWiki
$config["username_mw"] = "root";

// Contraseña de la BD de MediaWiki
$config["password_mw"] = "123456";

// Cuando modo_desarrollo == TRUE, se puede hacer login con
// cualquier nombre de usuario sin importar la contraseña
// IMPORTANTE: DESACTIVAR ANTES DE IR A PRODUCCIÓN
$config["modo_desarrollo"] = True;

// ID del usuario correspondiente al profesor/revisor (sistema antiguo)
//$config["usuarios_admin"] = array(1, 2);

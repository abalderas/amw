<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

    var $usuarios = array();
	private $link;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        // Cargamos el modelo de acceso a la BD de MediaWiki
		$this->load->model('acceso_model', 'bd');

		// Conectamos al Wiki
		$this->link = $this->bd->conectar_wiki();

		// Lanzamos el método listado para cargar los usuarios
		$this->listado();
    }
	function listado()
	{
		
		// Construimos la sentencia SQL para leer todos los usuarios
		$sql    = 'SELECT user_id, user_name FROM user';

		// Lanzamos la sentencia
		$result = mysql_query($sql, $this->link);

		// Guardamos todos los usuarios leidos en el array $this->usuarios
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$this->usuarios[$row[0]] = $row[1];
		}		
	}

	function users()
	{
		return $this->usuarios;
	}
	
	function admin($userid)
	{
		// Los usuarios que son ADMIN se definen en el fichero
		// application/config/amw.php

		return in_array($userid, $this->config->item("usuarios_admin"));
	}
}
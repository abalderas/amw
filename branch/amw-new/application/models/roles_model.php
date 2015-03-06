<?php
class Roles_model extends CI_Model {

	var $tabla = 'roles';
	var $asignacion = 'rol_assignation';
    private $rol_id;
	private $name;
	private $evaluar;
	private $metaevaluar;
	private $metaevaluar_lista;
	private $alumnos;
	private $parametros;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	//Funcion que devuelve true si el usuario es Administrado y false en caso contrario
	function es_admin($userid)
	{
		$user_rol = $this->get_user_rol_id($userid);

		if ($user_rol == 1) {
			return true;
		}

		return false;
	}

	//Devuelve el id del rol del usuario
	function get_user_rol_id($userid)
	{
		$result = array();

		$sql = 'SELECT rol_id' .
			' FROM rol_assignation ' .
			' WHERE user_id ='. $userid ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->rol_id);
		}
		
		array_push($result, "2"); //We asign to him the default value of Student to return it in case there isn't another one

		return $result[0];
	}

	//Devuelve el id del rol
	function get_rol_id($rol)
	{
		$result = array();

		$sql = 'SELECT rol_id' .
			' FROM roles ' .
			' WHERE name LIKE "'. $rol .'"' ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->rol_id);
		}

		return $result[0];
	}

	//Devuelve el nombre del rol del usuario
	function get_rol($userid)
	{
		$result = array();

		$sql = 'SELECT name' .
			' FROM roles ' .
			' WHERE rol_id ='. $this->get_user_rol_id($userid) ;
		//echo $sql;

		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->name);
		}

		return $result[0];
	}

	//Devuelve una lista con todos los ids de roles
	function get_rol_id_list()
	{
		$result = array();

		$sql = 'SELECT rol_id' .
			' FROM roles ';
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->rol_id);
		}

		return $result;
	}

	//Devuelve una lista con todos los nombres de roles
	function get_rol_list()
	{
		$result = array();

		$sql = 'SELECT name' .
			' FROM roles ';
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->name);
		}

		return $result;
	}

	//Devuelve true si el usuario tiene permiso para visitar la pagina seleccionada
	function comprobar_permisos($userid, $page)
	{
		$result = array();

		$rol_of_user = $this->get_user_rol_id($userid);
		
		$sql = 'SELECT roles.'.$page.'' .
			' FROM roles ' .
			' WHERE rol_id =' . $rol_of_user ;
		//echo $sql;

		$query = $this->db->query($sql);


		foreach ($query->result() as $row) 
		{
			array_push($result, $row->$page);
		}

		return $result[0];
	}

	//Dado un rol y una pagina devuelve true si tiene permiso de acceso
	function comprobar_permisos_de_rol($rol, $page)
	{
		$result = array();
		
		$sql = 'SELECT roles.'.$page.'' .
			' FROM roles ' .
			' WHERE name ="'.$rol.'"' ;
		//echo $sql;

		$query = $this->db->query($sql);


		foreach ($query->result() as $row) 
		{
			array_push($result, $row->$page);
		}

		return $result[0];
	}

	//Funcion que devuelve la lista de usuarios a la que se les ha asignado un rol
	function usuarios_con_roles()
	{
		$result = array();
		
		$sql = 'SELECT user_id' .
			' FROM rol_assignation ' .
			' WHERE 1 ';
		//echo $sql;

		$query = $this->db->query($sql);


		foreach ($query->result() as $row) 
		{
			array_push($result, $row->user_id);
		}

		return $result;
	}

	// Funcion que inserta en la tabla el nuevo rol con los datos indicados
	function insertar_rol($datos) 
	{
		$this->db->insert($this->tabla, $datos);
	}

	// Funcion que modifica los permisos de un rol
	function modificar_rol($datos) 
	{
		$this->db->where('name', $datos['name']);
		$this->db->update($this->tabla, $datos); 
	}

	// Funcion que elimina un rol
	function eliminar_rol($rol) 
	{
		$rol_id=$this->roles->get_rol_id($rol); //Obtenemos el id del rol a borrar

		if ($rol_id != 1 && $rol_id != 2) //Si no borramos ni al Administrador ni a los estudiantes
		{
			$this->db->where('rol_id', $rol_id);
			$this->db->delete($this->tabla); 
		} // Tras esto, si hay estudiantes que tenian dicho rol asignado hay que borrar dichas asignaciones	
	}

	// Funcion que asigna un rol a un usuario
	function asignar_rol($usuario, $rol) 
	{
		$rol_id=$this->roles->get_rol_id($rol); //Obtenemos el id del rol a borrar
		$usuarios = $this->acceso->usuarios()
		$user_id= //to do

		//Si el usuario tiene algo asignado
		//edita
		//else
		//inserta
	}
	// Funcion que deja a un usuario con el rol de estudiante
	
	function desasignar_rol($usuario) 
	{
		$rol_id=$this->roles->get_rol_id($rol); //Obtenemos el id del rol a borrar

		if ($rol_id != 1 && $rol_id != 2) //Si no borramos ni al Administrador ni a los estudiantes
		{
			$this->db->where('rol_id', $rol_id);
			$this->db->delete($this->tabla); 
		} 
	}
}
?>

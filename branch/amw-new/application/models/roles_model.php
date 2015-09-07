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

	//Devuelve el id del rol dado el nombre del mismo
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

	//Devuelve el nombre del rol dado el id del mismo
	function get_rol_name($rol_id)
	{
		$result = array();

		$sql = 'SELECT name' .
			' FROM roles ' .
			' WHERE rol_id ='. $rol_id ;
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

	//Devuelve la lista de id de los usuarios con el rol seleccionado
	function get_users_with_rol($rol_id)
	{
		$result = array();

		$sql = 'SELECT user_id' .
			' FROM rol_assignation ' .
			' WHERE rol_id ='. $rol_id;
		//echo $sql;

		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->user_id);
		}

		return $result;
	}

	//Devuelve un usuario con el rol seleccionado
	function get_user_with_rol($rol_id)
	{
		$result = array();

		$sql = 'SELECT user_id' .
			' FROM rol_assignation ' .
			' WHERE rol_id ='. $rol_id;
		//echo $sql;

		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->user_id);
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

	//Dado el id de un rol devuelve a cuantas personas les ha sido asignado
	function count_ammount_of_roles_assigned($rol_id)
	{		
		$result = array();

		$sql = 'SELECT COUNT(rol_id) AS cantidad' .
			' FROM rol_assignation ' .
			' WHERE rol_id = ' . $rol_id;
		//echo $sql;

		$query = $this->db->query($sql);

		foreach ($query->result() as $row) 
		{
			array_push($result, $row->cantidad);
		}

		return $result[0];
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
		$ammount = $this->count_ammount_of_roles_assigned($rol_id);

		while ($ammount != 0) //Volvemos a asignar a todos los usuarios que tenian ese rol como estudiantes
		{
			$user = $this->get_user_with_rol($rol_id);
			$this->db->where('user_id', $user);
			$this->db->delete($this->asignacion); 
			$ammount=$ammount-1;
		}

		if ($rol_id != 1 && $rol_id != 2) //Si no borramos ni al Administrador ni a los estudiantes
		{
			$this->db->where('rol_id', $rol_id);
			$this->db->delete($this->tabla); 
		} // Tras esto, si hay estudiantes que tenian dicho rol asignado hay que borrar dichas asignaciones	
	}

	// Funcion que asigna un rol a un usuario
	function asignar_rol($usuario, $rol) 
	{
		$rol_id = $this->roles->get_rol_id($rol); //Obtenemos el id del rol a asignar
		$user_id = $this->acceso->userid($usuario);
		$datos = array();
		
		$datos['user_id'] = $user_id; //Asignamos los datos al vector de entrada
		$datos['rol_id'] = $rol_id;

		if ($rol_id == 2) //Si queremos asignar el rol de estudiante
		{
			$this->db->where('user_id', $user_id);
			$this->db->delete($this->asignacion); 
		}
		else //Si queremos asignar un rol distinto al de estudiante
		{
				if ($this->roles->get_user_rol_id($user_id) == 2)//Si el usuario no tiene rol asignado (es estudiante)
			{
				$this->db->insert($this->asignacion, $datos);
			}
			else //Realizamos la busqueda y actualizamos los datos
			{
				$this->db->where('user_id', $user_id);
				$this->db->update($this->asignacion, $datos);
			}
		}
	}

	
}

?>

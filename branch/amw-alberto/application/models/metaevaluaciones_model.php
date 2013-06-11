<?php
class Metaevaluaciones_model extends CI_Model {
    
	var $tabla = 'metaevaluaciones';
	var $evaluaciones = 'evaluaciones';
	private $mev_id;
	private $mevaluador_id;
	private $evaluacion_id;
	private $calificacion;
	private $comentario;
	

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	// Inserta una metaevaluación en la base de datos
	function insertar_metaevaluacion($datos)
	{

		// Inserta en la tabla la evaluación con los datos indicados
		$this->db->insert($this->tabla, $datos);

		// Guarda los datos de la evaluación recién insertada
		$this->mev_id = $this->db->insert_id();
		
		// Al insertar podemos comprobar si ya
		// existe corrección de dicho artículo para
		// no permitir una nueva.
	}
	
	// Devuelve el identificador de la última metaevaluación insertada en la BD
	function id()
	{
		return $this->mev_id;
	}

	
	// Devuelve una lista de todas las metaevaluaciones realizadas
	function listado_metaevaluadas()
	{
		$listado = array();

		// Aislamos el campo con el número de metaevaluacion
		$this->db->select('mev_id');

		// Leemos los datos de la BD
		$query = $this->db->get($this->tabla);

		// Por cada fila, metemos en el array el ID de la metaevaluaciones
		foreach ($query->result() as $row)
		{
			array_push($listado, $row->mev_id);
		}
		return $listado;
	}

	// Funcion que devuelve la lista de IDs de evaluaciones a metaevaluar
	function para_metaevaluar()
	{
		$listado = array();
		
		$sql = 'SELECT eva_id' .
			' FROM evaluaciones' .
			' WHERE eva_id NOT IN ( ' . 
				' SELECT evaluacion_id' . 
				' FROM metaevaluaciones' . 
			')';
		// echo $sql;

		$query = $this->db->query($sql);

		// Por cada fila, metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			array_push($listado, $row->eva_id);
		}

		return $listado;
	}	

		// Devuelve las evaluaciones pendientes de evaluar evitando que un alumno se metaevalue a si mismo o donde haya sido evaluado
		function metavaluaciones_para_aumno($user)
	{
		$listado = array();
		
		$sql = 'SELECT eva_id' .
			' FROM evaluaciones ' .
			' WHERE eva_id NOT IN ( ' . 
				' SELECT evaluacion_id' . 
				' FROM metaevaluaciones' .
				' )' . 
				' AND eva_user !=' . $user .
				' AND eva_revisor !=' . $user ;

		// 	echo $sql;

		$query = $this->db->query($sql);

		// Por cada fila, metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			array_push($listado, $row->eva_id);
		}

		return $listado;
	}


	// Funcion que devuelve las metaevaluaciones que ha realizado un alumno
	function metaevaluaciones_realizadas($user)
	{
		$listado = array();
		
		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT mev_id'  
			. ' FROM metaevaluaciones'
			. ' WHERE mevaluador_id =' . $user
			. ' AND calificacion NOT LIKE 0' ;
		// echo $sql;
			
		$query = $this->db->query($sql);

		// Por cada fila, metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			array_push($listado, $row->mev_id);
		}

		return $listado;
	}

	// Dado el ID de una metaevaluacion devuelve el ID de la evaluacion metaevaluada
	function evaluacion_metaevaluada($id)
	{
		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT evaluacion_id ' .
			' FROM metaevaluaciones ' .
			' WHERE mev_id = ' . $id;
		//echo $sql;
			
		$query = $this->db->query($sql);

		// Por cada fila (que debe ser solo una), metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			$resultado = $row->evaluacion_id;
		}

		return $resultado;
	}

	// Dado el ID de una evaluacion devuelve la edicion a metaevaluar
	function edicion_metaevaluada($id)
	{
		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT eva_revision '  .
			' FROM evaluaciones ' .
			' WHERE eva_id = ' . $id;
		//echo $sql;
			
		$query = $this->db->query($sql);

		// pg_port() cada fila (que debe ser solo una), metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			$resultado = $row->eva_revision;
		}
		
		return $resultado;
	}

	// Dado el ID de una evaluacion devuelve la nota a calificacion
	function calificacion_metaevaluada($id)
	{
		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT ee_nota '  .
			' FROM evaluaciones_entregables ' .
			' WHERE eva_id = ' . $id;
		// echo $sql;

		$query = $this->db->query($sql);

		// pg_port() cada fila (que debe ser solo una), metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			$resultado = $row->ee_nota;
		}
		
		return $resultado;
	}

	// Dado el ID de una evaluacion devuelve el criterio de la calificacion
	function criterio_metaevaluada($id)
	{
		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT ent_entregable '  .
			' FROM entregables, evaluaciones_entregables ' .
			' WHERE eva_id = ' . $id .
			' AND entregables.ent_id = evaluaciones_entregables.ent_id' ;
		// echo $sql;

		$query = $this->db->query($sql);

		// pg_port() cada fila (que debe ser solo una), metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			$resultado = $row->ent_entregable;
		}

		return $resultado;
	}
	
	// Dado el ID de una evaluacion devuelve la descripcion de la calificacion
	function descripcion_metaevaluada($id)
	{
		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT ee_comentario '  .
			' FROM evaluaciones_entregables ' .
			' WHERE eva_id = ' . $id;
		// echo $sql;

		$query = $this->db->query($sql);

		// pg_port() cada fila (que debe ser solo una), metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			$resultado = $row->ee_comentario;
		}
	
		return $resultado;
	}

	// Dado el ID de una metaevaluacion devuelve la calificacion
	function get_calificacion($id)
	{
		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT calificacion '  .
			' FROM metaevaluaciones ' .
			' WHERE mev_id = ' . $id;
		// echo $sql;

		$query = $this->db->query($sql);

		// pg_port() cada fila (que debe ser solo una), metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			$resultado = $row->calificacion;
		}
	
		return $resultado;
	}
		// Dado el ID de una metaevaluacion devuelve su comentario
	function get_comentario($id)
	{
		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT comentario '  .
			' FROM metaevaluaciones ' .
			' WHERE mev_id = ' . $id;
		// echo $sql;

		$query = $this->db->query($sql);

		// pg_port() cada fila (que debe ser solo una), metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			$resultado = $row->comentario;
		}
	
		return $resultado;
	}
}
?>

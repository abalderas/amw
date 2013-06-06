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
	
	//Funcion que inserta una nueva metaevaluacion pendiente al generar una evaluacion (TODO: invocar esta funcion al crear la evaluacion)
	function insertar($evaluacion_id)
	{

		$data['mevaluador_id'] = 0; //No tendra metaevaluador hasta que a alguien no le toque metaevaluarla
		$data['evaluacion_id'] = $evaluacion_id; // Habria que almacenar la id de la evaluacion realizada
		// $data['evaluacion_id'] = $this->evaluacion->$eva_id;
		$data['calificacion'] = 0;
		$data['comentario'] = "";

		// Inserta en la tabla la metaevaluación con los datos indicados
		$this->db->insert($this->tabla, $data);

		// Guarda el ID de la metaevaluación recién insertada
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

	
	// Devuelve una lista de todas las metaevaluaciones
	function listado()
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

	// Funcion que devuelve la lista de evaluaciones a metaevaluar
	function para_metaevaluar()
	{
		$listado = array();
		
		$sql = 'SELECT mev_id' .
			' FROM metaevaluaciones ' .
			' where calificacion LIKE 0';
		//echo $sql;

		$query = $this->db->query($sql);

		// Por cada fila, metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			array_push($listado, $row->mev_id);
		}

		return $listado;
	}

	// Funcion que devuelve la lista de evaluaciones ya metaevaluadas
	function metaevaluadas()
	{
		$listado = array();
		
		$sql = 'SELECT mev_id' .
			' FROM metaevaluaciones ' .
			' where calificacion NOT LIKE 0';
		//echo $sql;
		
		$query = $this->db->query($sql);

		// Por cada fila, metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			array_push($listado, $row->mev_id);
		}
	

		return $listado;
	}

		// Devuelve las evaluaciones pendientes de evaluar evitando que un alumno se metaevalue a si mismo o donde haya sido evaluado
		function metavaluaciones_para_aumno($user)
	{
		$listado = array();
		
		$sql = 'SELECT mev_id' .
			' FROM metaevaluaciones, evaluaciones ' .
			' where calificacion LIKE 0' .
			' AND eva_id = evaluacion_id' .
			' AND eva_user !=' . $user .
			' AND eva_revisor !=' . $user ;
		//	echo $sql;

		$query = $this->db->query($sql);

		// Por cada fila, metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			array_push($listado, $row->mev_id);
		}

		return $listado;
	}


	// Funcion que devuelve las metaevaluaciones que ha realizado un alumno
	function metaevaluaciones_realizadas($user)
	{
		$listado = array();
		
		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT mev_id '  
			. 'FROM metaevaluaciones '
			. 'WHERE mevaluador_id =' . $user
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

	// Funcion que crea una metaevaluacion para las evaluaciones que aun no la tengan
	function reload()
	{
		$listado = array();
		
		$sql = 'SELECT eva_id' .
			' FROM evaluaciones' .
			' where eva_id NOT ' .
			'IN (' .
				'SELECT evaluacion_id' .
				' FROM metaevaluaciones' .
			')';
		//echo $sql;
		
		$query = $this->db->query($sql);

		// Por cada fila, metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			$this->insertar($row->eva_id);
		}
	}

	// Fuincion que modifica los datos de una metaevaluacion (salvo la id de la metaevaluacion)
	function modificar($data)
	{

		$sql = 'UPDATE metaevaluaciones' .
		' SET mevaluador_id = ' . $data['mevaluador_id'] . ',' .
			' calificacion = ' . $data['calificacion'] . ',' .
			' comentario = ' . $data['comentario'] . ',' .
		' WHERE evaluacion_id = ' . $data['evaluacion_id'];

		echo $sql;

		//comprobar query
		$query = $this->db->query($sql);


		mysqli_query($con, $sql); //problemas con las funciones de modificar los datos de las tablas
		mysqli_close($con);


		// Inserta en la tabla la metaevaluación con los datos indicados
		// $this->db->insert($this->tabla, $data);

		// Guarda el ID de la metaevaluación recién modificada
		// $this->mev_id = $this->db->insert_id();
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

		// Dado el ID de una metaevaluacion devuelve la entrada evaluada a metaevaluar
	function entrada_metaevaluada($id)
	{		

		$eva_id = $this->evaluacion_metaevaluada($id);

		// Generamos las posibilidades SQL igualando la id de usuario y eliminando las que no han sido calificadas
		$sql = 'SELECT eva_revision '  .
			' FROM evaluaciones, metaevaluaciones ' .
			' WHERE mev_id = ' . $id .
			' AND eva_id = ' . $eva_id;
		//echo $sql;
			
		$query = $this->db->query($sql);

		// Por cada fila (que debe ser solo una), metemos en el array el ID de la metaevaluacion
		foreach ($query->result() as $row)
		{
			$resultado = $row->eva_revision;
		}
		
		return $resultado;
	}

}
?>

<?php
class Evaluation_exercise_model extends CI_Model {

	var $tabla = 'ejercicios_de_evaluacion';
	var $asignations = 'categorias_ej_ev';
	var $tabla_preasignaciones = 'preasignaciones';
	var $rafagas = 'rafagas';
    private $evaluation_id;
	private $exercise_name;
	private $beginning;
	private $first_phase_end;
	private $second_phase_end;
	private $third_phase_end;
	private $forth_phase_end;
	private $description;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function get_ee_name($id)
	{
		$result = array();

		$sql = 'SELECT exercise_name' .
			' FROM ' . $this->tabla .
			' WHERE evaluation_id ='. $id ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->exercise_name);
		}

		return $result[0];
	}

	function get_ee_beginning($id)
	{
		$result = array();

		$sql = 'SELECT beginning' .
			' FROM ' . $this->tabla .
			' WHERE evaluation_id ='. $id ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->beginning);
		}

		return $result[0];
	}

	function get_ee_first_phase_end($id)
	{
		$result = array();

		$sql = 'SELECT first_phase_end' .
			' FROM ' . $this->tabla .
			' WHERE evaluation_id ='. $id ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->first_phase_end);
		}

		return $result[0];
	}

	function get_ee_second_phase_end($id)
	{
		$result = array();

		$sql = 'SELECT second_phase_end' .
			' FROM ' . $this->tabla .
			' WHERE evaluation_id ='. $id ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->second_phase_end);
		}

		return $result[0];
	}

	function get_ee_third_phase_end($id)
	{
		$result = array();

		$sql = 'SELECT third_phase_end' .
			' FROM ' . $this->tabla .
			' WHERE evaluation_id ='. $id ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->third_phase_end);
		}

		return $result[0];
	}

	function get_ee_fourth_phase_end($id)
	{
		$result = array();

		$sql = 'SELECT fourth_phase_end' .
			' FROM ' . $this->tabla .
			' WHERE evaluation_id ='. $id ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->fourth_phase_end);
		}

		return $result[0];
	}

	function get_ee_description($id)
	{
		$result = array();

		$sql = 'SELECT description' .
			' FROM ' . $this->tabla .
			' WHERE evaluation_id ='. $id ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->description);
		}

		return $result[0];
	}

	//Devuelve una lista con todos los ids de los ejercicios de evaluacion
	function get_ee_id_list()
	{
		$result = array();

		$sql = 'SELECT evaluation_id' .
			' FROM ' . $this->tabla;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->evaluation_id);
		}

		return $result;
	}

	//Devuelve el id de un ejercicio de evaluacion dado su nombre
	function get_ee_id($name)
	{
		$result = array();

		$sql = 'SELECT evaluation_id' .
			' FROM ' . $this->tabla .
			' WHERE exercise_name LIKE "'. $name .'"' ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->evaluation_id);
		}

		return $result[0];
	}

	// Funcion que inserta en la tabla el nuevo rol con los datos indicados
	function insertar_evaluation_exercise($datos) 
	{
		if ($datos['beginning'] < $datos['first_phase_end'])
			if ($datos['first_phase_end'] < $datos['second_phase_end'])
				if ($datos['second_phase_end'] < $datos['third_phase_end'])
					if ($datos['third_phase_end'] < $datos['fourth_phase_end'])
						$this->db->insert($this->tabla, $datos);
	}

	// Funcion que modifica los permisos de un rol
	function modificar_evaluation_exercise($datos) 
	{
		if ($datos['beginning'] < $datos['first_phase_end'])
			if ($datos['first_phase_end'] < $datos['second_phase_end'])
				if ($datos['second_phase_end'] < $datos['third_phase_end'])
					if ($datos['third_phase_end'] < $datos['fourth_phase_end'])
					{
						$this->db->where('evaluation_id', $datos['evaluation_id']);
						$this->db->update($this->tabla, $datos); 
					}
	}

	// Funcion que elimina un rol
	function eliminar_evaluation_exercise($name) 
	{
		$this->db->where('evaluation_id', $this->get_ee_id($name));
		$this->db->delete($this->tabla); 
	}

	function add_category_to_ee($ee, $categoria)
	{
		$datos['evaluation_id'] = $ee;
		$datos['ent_id'] = $categoria;
		$this->db->insert($this->asignations, $datos);
	}

	function delete_category_from_ee($ee, $categoria)
	{
		$this->db->where('evaluation_id', $ee);
		$this->db->where('ent_id', $categoria);
		$this->db->delete($this->asignations); 
	}

	//Funcion que devuelve los usuarios que han echo alguna edicion en un ejercicio de evaluacion
	function get_users_for_ee ($ee)
	{
		//Buscamos los alumnos que hayan echo alguna edicion en esas fechas
		$inicio_edicion = $this->get_ee_first_phase_end($ee);
		$fin_edicion = $this->get_ee_second_phase_end($ee);
		//Adaptamos los timestamp a la fecha almacenada en la bd
		$inicio_edicion = str_replace('-', '', $inicio_edicion).'000000';
		$fin_edicion = str_replace('-', '', $fin_edicion).'235959';

		$result = array();

		$sql = 'SELECT DISTINCT rev_user' .
			' FROM mediawikidb.revision' .
			' WHERE rev_timestamp  BETWEEN ' . $inicio_edicion . ' AND ' . $fin_edicion;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->rev_user);
		}

		return $result;
	}

	//Funcion que de vuelve la lista de IDs a evaluar en un ejercicio de evaluacion
	function get_revisions_for_ee($ee)
	{
		//Buscamos los alumnos que hayan echo alguna edicion en esas fechas
		$inicio_edicion = $this->get_ee_first_phase_end($ee);
		$fin_edicion = $this->get_ee_second_phase_end($ee);
		//Adaptamos los timestamp a la fecha almacenada en la bd
		$inicio_edicion = str_replace('-', '', $inicio_edicion).'000000';
		$fin_edicion = str_replace('-', '', $fin_edicion).'235959';

		$result = array();

		$sql = 'SELECT DISTINCT raf_start' .
			' FROM rafagas' .
			' WHERE raf_timestamp  BETWEEN ' . $inicio_edicion . ' AND ' . $fin_edicion  .
			' ORDER BY raf_size DESC ';
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->raf_start);
		}

		return $result;
	}

	//Funcion que devuelve las IDs de un numero minimo de ediciones (las mas relevantes) de cada usuario
	function recive_minimun_of_evaluations($ee, $min, $users)
	{
		//Buscamos los alumnos que hayan echo alguna edicion en esas fechas
		$inicio_edicion = $this->get_ee_first_phase_end($ee);
		$fin_edicion = $this->get_ee_second_phase_end($ee);
		//Adaptamos los timestamp a la fecha almacenada en la bd
		$inicio_edicion = str_replace('-', '', $inicio_edicion).'000000';
		$fin_edicion = str_replace('-', '', $fin_edicion).'235959';

		$result = array();

		foreach ($users as $user) 
		{
			$sql = 'SELECT DISTINCT raf_start' .
				' FROM amw.rafagas, mediawikidb.revision' .
				' WHERE raf_timestamp  BETWEEN ' . $inicio_edicion . ' AND ' . $fin_edicion  .
				' AND rev_id = raf_start ' .
				' AND rev_user = ' . $user .
				' ORDER BY raf_size DESC LIMIT ' . $min;
			//echo $sql;
				
			$query = $this->db->query($sql);
	
			foreach ($query->result() as $row)
			{
				array_push($result, $row->raf_start);
			}
		}

		return $result;
	}

	//Funcion que dado un array lo devuelve ordenado aleatoriamente
	function barajado_aleatorio ($array)
	{
		for ($i=count($array)-1; $i > 1 ; $i--) 
		{ 
			$random = rand(0, $i);
			$tmp = $array[$random];
			$array[$random]=$array[$i];
			$array[$i]=$tmp;
		}
		return $array;
	}

	//Funcion que devuelve el id del creador de una edicion
	function creator_of_edition ($id)
	{
		$result = array();

		$sql = 'SELECT DISTINCT rev_user' .
			' FROM mediawikidb.revision' .
			' WHERE rev_id =' . $id;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->rev_user);
		}

		return $result[0];
	}
	
	//Funcion que devuelve true si encuentra una autoevaluacion
	function check_autoevaluations ($user, $revision)
	{
		if ($user == $this->creator_of_edition($revision))
		{
			//echo "AUTOEVALUACION!!! User: ". $user . " Creator of: " . $revision . "<br>" ;
			return 1;
		}
		return 0;
	}

	//Funcion que realiza las preasignaciones en las que NO hay minimo de ediciones a evaluar por alumno y NO se permiten la autoevaluacion
	function preasignations_no_min ($users, $revisions, $ee, $amount, $evals_per_edition, $auto)
	{
		$para_evaluar= array();
		$acum = 0; //Acumulador de evaluaciones asignadas a cada alumno
		
		for ($i=0; $i * $evals_per_edition < $amount; $i++) //Haremos tantas pasadas como numeros de ediciones tenga que evaluar cada alumno
		{ 			
			for ($j=0; $j < count($users) ; $j++) 
			{ 
				$para_evaluar[$j] = $revisions[$j]; //Vamos almacenando todas las ediciones a evaluar en esta pasada en una lista
			}

			for ($k=0; $k <= $evals_per_edition && $acum < $amount; $k++) //Para cada edicion hacemos tantas pasadas como evaluaciones deba recibir
			{ 
				if ($auto == 0) //Si no se permiten autoevaluaciones
				{
					do //Ordenaremos los usuarios de forma aleatoria e iremos barajandolos hasta que obtengamos una pareja de listas (alumnos, ediciones) sin autoevaluaciones
					{
						$flag = 0; //Contador de autoevaluaciones
						$users = $this->evaluation_exercise->barajado_aleatorio($users); //Ordenamos los usuarios de forma aleatoria
						foreach ($users as $key => $user) //Rrecorremos las listas 
						{
							$flag = $flag + $this->check_autoevaluations($user, $para_evaluar[$key]); //Si encontramos autoevaluaciones sumamos 1 a flag
						}
						//echo "Flags = " . $flag . "<br>"; //Cantidad de autoevaluaciones encontradas en la pasada
					}
					while ($flag > 0); //En este punto tendremos una lista aleatoria de usuarios sin que se produzcan autoevaluaciones
				}
	
				foreach ($users as $key => $user) //Introducimos las preasignaciones en la base de datos
				{
					//echo "Alumno: " . $user . " Edicion: " . $revisions[$key] . "<br>"; 
					$this->make_preasignation($user, $para_evaluar[$key], $ee);
				}
			$acum++;
			}
			//En este punto cada edicion debe haber recibido el minimo de evaluaciones, tras eso las quitamos de la lista
			$revisions = array_merge(array_diff($revisions, $para_evaluar)); //Eliminamos de la lista de ediciones las ya introducidas y reindexamos
		}
	}

	//Funcion que realiza las preasignaciones en las que SI hay minimo de ediciones a evaluar por alumno y NO se permiten la autoevaluacion
	function preasignations_with_min ($users, $revisions, $ee, $amount, $evals_per_edition, $auto, $min)
	{
		$para_evaluar= array();
		$min_revisions = $this->recive_minimun_of_evaluations($ee, $min, $users); //Obtenemos las ediciones mas significativas de cada usuario
		$revisions = array_merge(array_diff($revisions, $min_revisions)); //Y las eliminamos de la lista de ediciones y reindexamos
		$acum = 0; //Acumulador de evaluaciones asignadas a cada alumno
		echo "Repaso: alumnos x min_ediciones_evauadas = lista -> " . count($users) . " x " . $min . " = " . count($min_revisions) . "<br>";
		//Puede darse el caso de que un alumno haya echo menos ediciones que el minimo que queremos que se evalue por cada alumno
		//En ese caso rellenaremos la ronda con las ediciones mas significativas sin importar el autor
		$cont = 0;
		if (count($users) * $min != count($min_revisions)) //Si no hay ediciones para todos los usuarios
		{
			for ($k=0; $k < count($users) * $min - count($min_revisions) ; $k++) //Las ediciones que faltan son = usuarios * minimo ediciones - existentes en la lista
			{ 
				for ($l= count($min_revisions); $l <count($users) * $min ; $l++) //Nos posicionamos en la primera posicion vacia del vector de ediciones minimas
				{ 
					$min_revisions[$l] = $revisions [$cont]; //Añadimos la siguiente edicion mas grande para rellenar, sin importar su creador
					//echo "Relleno con " . $cont . " en " . $l . "<br>";
					$cont++; //Pasamos a la siguiente edicion mas grande sin importar su creador
				}
			}
		}

		$revisions = array_merge(array_diff($revisions, $min_revisions)); //Sacamos de la lista de ediciones las N ediciones de cada estudiante y las de relleno
		
		for ($i=0; $i < $min ; $i++) //Haremos tantas pasadas como numeros de ediciones tenga que evaluar cada alumno
		{ 			
			for ($j=0; $j < count($users) ; $j++) 
			{ 
				$para_evaluar[$j] = $min_revisions[$j]; //Vamos almacenando todas las ediciones a evaluar en una lista de esta pasada
			}

			for ($k=0; $k < $evals_per_edition && $acum < $amount ; $k++) //Para cada edicion hacemos tantas pasadas como evaluaciones deba recibir
			{
				$users = $this->evaluation_exercise->barajado_aleatorio($users); //Ordenamos los usuarios de forma aleatoria
				
				if ($auto == 0) //Si no se permiten autoevaluaciones
				{
					do //Ordenaremos los usuarios de forma aleatoria e iremos barajandolos hasta que obtengamos una pareja de listas (alumnos, ediciones) sin autoevaluaciones
					{
						$flag = 0; //Contador de autoevaluaciones
						$users = $this->evaluation_exercise->barajado_aleatorio($users); //Ordenamos los usuarios de forma aleatoria
						foreach ($users as $key => $user) //Rrecorremos las listas 
						{
							$flag = $flag + $this->check_autoevaluations($user, $para_evaluar[$key]); //Si encontramos autoevaluaciones sumamos 1 a flag
						}
						//echo "Flags = " . $flag . "<br>"; //Cantidad de autoevaluaciones encontradas en la pasada
					}
					while ($flag > 0); //En este punto tendremos una lista aleatoria de usuarios sin que se produzcan autoevaluaciones
				}
				
				foreach ($users as $key => $user) //Introducimos las preasignaciones en la base de datos
				{
					//echo "Alumno: " . $user . " Edicion: " . $para_evaluar[$key] . "<br>";
					$this->make_preasignation($user, $para_evaluar[$key], $ee);				
				}
			$acum++;
			}
			//En este punto cada edicion debe haber recibido el minimo de evaluaciones, tras eso las quitamos de la lista
			$min_revisions = array_merge(array_diff($min_revisions, $para_evaluar)); //Eliminamos de la lista de ediciones las ya introducidas y reindexamos
		}
		//Cuando hayamos completado el cupo de ediciones minimas a evaluar asignamos el resto de forma normal
		$this-> preasignations_no_min ($users, $revisions, $ee, ($amount - ($min * $evals_per_edition)), $evals_per_edition, $auto);
	}

	//Funcion que devuelve una lista de ejercicios de evaluacion que ya tienen preasignaciones asignadas
	function get_ee_with_preasignations()
	{
		$result = array();

		$sql = 'SELECT DISTINCT ejercicio_de_evaluacion' .
			' FROM preasignaciones';			
		//echo $sql;

		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->ejercicio_de_evaluacion);
		}

		return $result;
	}

	//Funcion que devuelve la lista de ejercicios de evaluacion para los que no se han echo las preasignaciones
	function avalibles_for_preasignations ()
	{
		$list = $this->get_ee_id_list(); //Lista de todos los ejercicios de evaluacion
		$preasignadas = $this->get_ee_with_preasignations(); //Ejercicios de evaluacion con preasignaciones echas
		return array_merge(array_diff($list, $preasignadas)); //Ejercicios de evaluacion - Ejercicios de evaluacion con preasignaciones
	}

	//Funcion para intrudocir las preasignaciones en la base de datos
	function make_preasignation($user, $revision, $ee)
	{
		$datos['edit_id'] = $revision;
		$datos['revisor_id'] = $user;
		$datos['ejercicio_de_evaluacion'] = $ee;
		$this->db->insert($this->tabla_preasignaciones, $datos);
	}

	function get_editions_of_ee($ee)
	{
		$result = array();

		$sql = 'SELECT edit_id' .
			' FROM preasignaciones' .
			' WHERE ejercicio_de_evaluacion =' . $ee;			
		//echo $sql;

		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->edit_id);
		}

		return $result;
	}

	function delete_from_preasignations($edition)
	{
		$this->db->where('edit_id', $edition);
		$this->db->delete($this->tabla_preasignaciones); 
	}

	/// Devuelve el número de evaluaciones realizadas por un usuario
	function realizadas($user)
	{
		$articulos = array();
		
		// Generamos las posibilidades SQL.
		$sql = 'SELECT count(*) cant ' 
			. 'FROM preasignaciones '
			. 'WHERE revisor_id =' . $user;
			
		$result = $this->db->query($sql);
		
		$cantidad = $result->row();
		
		return $cantidad->cant;
	}

	//Funcion que devuelve el ID de una revision de la lista de preasignaciones para que la evalue el usuario
	function get_one_edition_for($user)
	{
		$result = array();

		$sql = 'SELECT edit_id' .
			' FROM preasignaciones' .
			' WHERE revisor_id =' . $user;			
		//echo $sql;

		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->edit_id);
		}

		return $result[0];
	}

	//Funcion que devuelve la rubrica de una edicion
	function get_description_from_edition($edition)
	{
		$result = array();

		$sql = 'SELECT ejercicio_de_evaluacion' .
			' FROM preasignaciones' .
			' WHERE edit_id =' . $edition;			
		//echo $sql;

		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->ejercicio_de_evaluacion);
		}

		return $this->get_description_from_ee($result[0]);
	}

	//Funcion que devuelve la rubrica de un ejercicio de evaluacion
	function get_description_from_ee($ee)
	{
		$result = array();

		$sql = 'SELECT description' .
			' FROM ejercicios_de_evaluacion' .
			' WHERE evaluation_id =' . $ee;			
		//echo $sql;

		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->description);
		}

		return $result[0];
	}

//Funcion que dada una edicion busca si hay alguna que se haya echo en una diferencia de tiempo X
	function deteccion_de_rafagas($ee)
	{
		$time_diff = 1800; //Diferencia de tiempo para considerar una rafaga en segundos (30 min * 60 seg = 1800seg)
		$pages = $this->get_list_of_pages();
		
		foreach ($pages as $page_key => $page) 
		{
			$edits = $this->get_edits_of_page($page, $ee);

			if (count($edits) > 0) //Si la pagina tiene alguna edicion
			{
				$current = 0;

				$data['raf_start'] = $edits[$current];
				$data['raf_end'] = $edits[$current];
				$data['raf_timestamp'] = $this->get_edit_timestamp($edits[$current]);
				$data['raf_size'] = $this->get_edit_size($edits[$current]);
				
				for ($next=1; $next < count($edits) ; $next++) 
				{ 
					$t1 =$this->get_edit_timestamp($edits[$current]);
					$t2 =$this->get_edit_timestamp($edits[$next]);
					//Si el creador de la siguiente edicion es el mismo que el de la actual no se excede el tiempo para que se considere rafaga
					if ( $this->tiempo_entre_ediciones($data['raf_timestamp'], $this->get_edit_timestamp($edits[$next]), $time_diff) && $this->creator_of_edition($edits[$current]) == $this->creator_of_edition($edits[$next])) 
					{
						$data['raf_end'] = $edits[$next];
						$data['raf_timestamp'] = $this->get_edit_timestamp($edits[$next]);
						$data['raf_size'] = $data['raf_size'] + $this->get_edit_size($edits[$next]);
					}
					else //Si la siguiente edicion no es rafaga introducimos los datos actuales y desplazamos los punteros
					{
						if ($this->buscar_rafaga($data['raf_start']) == 0)//Si la rafaga no existe la insertamos
						{
							//echo "Guardo la rafaga: " . $data["raf_start"]  . " - " . $data["raf_end"] . "<br>";
							$this->db->insert($this->rafagas, $data);

						}							
						else //Si existe la actualizamos (opcional, mas lento si ya se hicieron preasignaciones)
						{
							//echo "Actualizo la rafaga: " . $data["raf_start"] . " - " . $data["raf_end"] . "<br>";
							$this->db->where('raf_start', $data['raf_start']);
							$this->db->update('rafagas', $data); 
						}
							
						//Reiniciamos la informacion para la proxima rafaga
						$current = $next;
						$data['raf_start'] = $edits[$current];
						$data['raf_end'] = $edits[$current];
						$data['raf_timestamp'] = $this->get_edit_timestamp($edits[$current]);
						$data['raf_size'] = $this->get_edit_size($edits[$current]);
					}				
				}
			}			
		}
	}

	//Funcion que devuelve la lista de ids de las paginas existentes
	function get_list_of_pages()
	{
		$result = array();

		$sql = 'SELECT DISTINCT page_id' .
			' FROM mediawikidb.page' ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->page_id);
		}

		return $result;
	}

	//Funcion que devuelve la lista de ids de las ediciones de la pagina seleccionada para la deteccion de rafagas
	function get_edits_of_page($page, $ee)
	{
		//Filtraremos las ediciones por fecha,
		$inicio_edicion = $this->get_ee_first_phase_end($ee);
		$fin_edicion = $this->get_ee_second_phase_end($ee);
		//Adaptamos los timestamp a la fecha almacenada en la bd
		$inicio_edicion = str_replace('-', '', $inicio_edicion).'000000';
		$fin_edicion = str_replace('-', '', $fin_edicion).'235959';
		$result = array();

		$sql = 'SELECT rev_id' .
			' FROM mediawikidb.revision' .
			' WHERE rev_timestamp  BETWEEN ' . $inicio_edicion . ' AND ' . $fin_edicion . 
			' AND rev_page  = ' . $page .
			' ORDER BY rev_timestamp ';
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->rev_id);
		}

		return $result;
	}

	//Funcion que devuelve la fecha de creacion de una edicion
	function get_edit_timestamp($edit)
	{
		$result = array();

		$sql = 'SELECT rev_timestamp' .
			' FROM mediawikidb.revision' .
			' WHERE rev_id =' . $edit;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->rev_timestamp);
		}

		return $result[0];
	}

	//Funcion que devuelve el tamaño de una edicion
	function get_edit_size($edit)
	{
		$result = array();

		$sql = 'SELECT rev_len' .
			' FROM mediawikidb.revision' .
			' WHERE rev_id =' . $edit;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->rev_len);
		}

		return $result[0];
	}

	function tiempo_entre_ediciones ($dt1, $dt2, $dif)
	{

    	if( is_string($dt1)) $dt1 = date_create($dt1);
       	if( is_string($dt2)) $dt2 = date_create($dt2);

       	$diff = date_diff($dt1, $dt2);
     
        
       	$total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
       	
       	if ($total < $dif) 
       	{
       		return true;
       	}
       	else
       	{
       		return false;
       	}
	}

	//Funcion que devuelve 0 si una rafaga no existe
	function buscar_rafaga($id)
	{
		$result = array();

		$sql = 'SELECT raf_start' .
			' FROM rafagas' .
			' WHERE raf_start =' . $id;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->raf_start);
		}
		array_push($result, "0"); //Si no encuentra nada devolvera 0

		return $result[0];
	}

	//Funcion que devuelve el id del finde una rafaga dado el id inicial
	function buscar_fin_rafaga($id)
	{
		$result = array();

		$sql = 'SELECT raf_end' .
			' FROM rafagas' .
			' WHERE raf_start =' . $id;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->raf_end);
		}
		array_push($result, "0"); //Si no encuentra nada devolvera 0

		return $result[0];
	}
}
?>

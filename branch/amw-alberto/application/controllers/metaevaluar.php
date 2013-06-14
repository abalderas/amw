<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metaevaluar extends CI_Controller {	
	
	public function test(){

		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('acceso_model', 'acceso');
		
		$id = $this->session->userdata('userid');

		$filtro = $this->metaevaluaciones->metavaluaciones_para_aumno($id);
		$por_metaevaluar = $this->metaevaluaciones->para_metaevaluar();
		$metaevaluadas = $this->metaevaluaciones->listado_metaevaluadas();
		$realizadas = $this->metaevaluaciones->metaevaluaciones_realizadas($id);

		$variable = $this->acceso->usuarios();
		foreach ($variable as $key => $value) {
			echo "Seguimiento" . $key . "=> ". $value . "<br>";
			}



		echo "Quedan por metaevaluar " . count($por_metaevaluar) . " evaluaciones <br>";
		echo "De las que quedan por metaevaluar " . count($filtro) . " no son evaluaciones ni ediciones mias <br>";
		echo "Han sido metaevaluadas " . count($metaevaluadas) . " evaluaciones <br>";
		echo "He echo: " . count($realizadas) . " metaevaluaciones <br>";


		// $id = $this->metaevaluaciones->evaluacion_metaevaluada(0);


		echo "He metaevaluado: <br>";
		foreach ($realizadas as $key) {
			echo $key . "<br>";
		}
		
		echo "Por metaevaluar: <br>";
		foreach ($por_metaevaluar as $key) {
			echo $key . "<br>";
		}

				echo "Para alumno logeado: <br>";
		foreach ($filtro as $key) {
			echo $key . "<br>";	
		}	

		echo "Metaevaluadas: <br>";
		foreach ($metaevaluadas as $key) {
			echo $key . "<br>";	
		}
	}

	public function index()
	{
		// redirect('metaevaluar/test');

		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('Parametros_model', 'parametros');
			
		$max_mevs = $this->parametros->get_metaevaluaciones_por_alumno();

		// Leemos el ID del usuario logueado
		$usuario_id = $this->session->userdata('userid');

		// Si el numero de evaluaciones para metaevaluar es mayor que 0
		$por_metaevaluar = $this->metaevaluaciones->para_metaevaluar();

		if (count($por_metaevaluar) > 0)
		{
			// Elegimos una de las evaluaciones de forma aleatoria
			$aleatorio = rand(0, (count($por_metaevaluar)-1));

			// Guardamos la id de la evaluacion elegida 
			$data['evaluacion'] = $por_metaevaluar[$aleatorio];
		
			// Obtenemos los datos de la edicion evaluada que estamos metaevaluando
			$data['edicion'] = $this->metaevaluaciones->edicion_metaevaluada($data['evaluacion']); // Para generar la url de la edicion
			$data['calificacion'] = $this->metaevaluaciones->calificacion_metaevaluada($data['evaluacion']); // Calificacion de la evaluacion
			$data['criterio'] = $this->metaevaluaciones->criterio_metaevaluada($data['evaluacion']); // Criterio de la evaluacion
			$data['descripcion'] = $this->metaevaluaciones->descripcion_metaevaluada($data['evaluacion']); // Descripcion de la evaluacion

			$evaluacion = $this->evaluaciones->consultar_entregables($data['evaluacion']); //Modificar
		}
		
		if ($max_mevs > 0)
		{
			// Calculamos el número de metaevaluaciones que aún debe hacer el usuario
			$data['metaevaluaciones_pendientes'] = $max_mevs - count($this->metaevaluaciones->metaevaluaciones_realizadas($usuario_id));
		}

		$data['usuario'] = $this->session->userdata('username');
		$this->load->view('template/header');
		$this->load->view('template/menu');

		// Si finalmente hay alguna evaluacion a metaevaluar
		$para_alumno = $this->metaevaluaciones->metavaluaciones_para_aumno($usuario_id);
		if (count($para_alumno) > 0)
		{
			log_message('error',$data["usuario"]);

			$data['msg'] = "You may grade the evaluation of the revision here below.";

			$data['post_url'] = 'metaevaluar/procesar';

			//$evaluar->mostrar_evaluacion($data['evaluacion']); // con algo asi se podria cargar la evaluacion y no seria tan complicado
			$this->load->view('hello_evaluacion', $data);
			$this->load->view('previa_evaluacion');
		}

		// Si no hay ninguna revisión a metaevaluar
		else
		{			
			$this->load->view('no_evaluacion', $data); //cambiar a no evaluacion
		}

		$this->load->view('template/footer');
	}

	// Esta funcion muestra los datos de una metaevaluacion y ofrece la posibilidad de modificarlos
	public function procesar()
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('Evaluaciones_model', 'evaluaciones');

		if ($this->input->post('puntuacion') == 0)
			redirect('evaluar/index');
		
		else
		{
		
		$datos['mevaluador_id'] = $this->session->userdata('userid'); // El metaevaluador sera el usuario logeado
		echo "Seguimiento del id del usuario logeado : " . $this->session->userdata('userid') . "<br>";
		
		$datos['evaluacion_id'] = $this->input->post('id_evaluation');; // La id de la evaluacion ha de permanecer como cuando se creo, para saber cual es
		echo "Seguimiento de la calificacion : " . $this->input->post('id_evaluation') . "<br>";

		$datos['calificacion'] = $this->input->post('puntuacion'); // Leemos la nota que haya introducido el metaevaluador
		echo "Seguimiento de la calificacion : " . $this->input->post('puntuacion') . "<br>";
		
		$datos['comentario'] = $this->input->post('comentario'); // Leemos el comentario introducido
		echo "Seguimiento del comentario : " . $this->input->post('comentario') . "<br>";

		$this->metaevaluaciones->insertar_metaevaluacion($datos); //Creamos la metaevaluacion en la tabla

		$this->mostrar_metaevaluacion($this->metaevaluaciones->id());
		}
	}

	// Muestra la información relacionada con una metaevaluación
	function mostrar_metaevaluacion($mev = 0)
	{				
		$colors = array("#99C68E", "#F9966B", "#FDD017", "#EBDDE2", "#5CB3FF", "#736F6E");
		$this->load->model('Reply_model', 'reply');		
		$this->load->model('Acceso_model', 'acceso');
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		
		$data['metaevaluacion'] = $mev;
		$data['usuario'] = $this->session->userdata('username');
		$data['usuario_id'] = $this->session->userdata('userid');
		$data['evaluacion'] = $this->metaevaluaciones->evaluacion_metaevaluada($mev); // Id de la evaluacion
		$data['edicion'] = $this->metaevaluaciones->edicion_metaevaluada($data['evaluacion']);	// Enlace a la edicion
		$data['calificacion_eva'] = $this->metaevaluaciones->calificacion_metaevaluada($data['evaluacion']); // Nota de la evaluacion
		$data['criterio_eva'] = $this->metaevaluaciones->criterio_metaevaluada($data['evaluacion']); // Criterio evaluadi
		$data['descripcion_eva'] = $this->metaevaluaciones->descripcion_metaevaluada($data['evaluacion']); // Descripcion de la evaluacion
		$data['calificacion_mev'] = $this->metaevaluaciones->get_calificacion($mev); // Nota de la metaevaluacion
		$data['comentario_mev'] = $this->metaevaluaciones->get_comentario($mev); // Descripcion de la metaevaluacion

		$this->load->view('info_evaluacion', $data);
		
		$this->load->view('template/footer');
	}

	function lista ()
	{
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Acceso_model', 'acceso');

		$this->load->view('template/header');
		$this->load->view('template/menu');	

		// $lista = $this->metaevaluaciones->listado_metaevaluadas_ordenado();
		$data['metaevaluacion'] = $this->metaevaluaciones->listado_metaevaluadas_ordenado();

		if (count($data['metaevaluacion']) == 0)
			$this->load->view('no_metaevaluacion');
		else
		{
			$data['total'] = count($data['metaevaluacion']);
			$usuarios = $this->acceso->usuarios();
			foreach ($data['metaevaluacion'] as $value) {
				$data['evaluacion'][$value] = $this->metaevaluaciones->evaluacion_metaevaluada($value); // Id de la evaluacion
				$data['edicion'][$value] = $this->metaevaluaciones->edicion_metaevaluada($data['evaluacion'][$value]);	// Enlace a la edicion
				$data['calificacion_eva'][$value] = $this->metaevaluaciones->calificacion_metaevaluada($data['evaluacion'][$value]); // Nota de la evaluacion
				$data['criterio_eva'][$value] = $this->metaevaluaciones->criterio_metaevaluada($data['evaluacion'][$value]); // Criterio evaluadi
				$data['descripcion_eva'][$value] = $this->metaevaluaciones->descripcion_metaevaluada($data['evaluacion'][$value]); // Descripcion de la evaluacion
				$data['calificacion_mev'][$value] = $this->metaevaluaciones->get_calificacion($value); // Nota de la metaevaluacion
				$data['comentario_mev'][$value] = $this->metaevaluaciones->get_comentario($value); // Descripcion de la metaevaluacion
				$data['usuario_id'][$value] = $this->metaevaluaciones->get_mevaluatorid($value);  // ID del usuario metaevaluador
				$data['usuario'][$value] = $usuarios[$data['usuario_id'][$value]]; // Nombre del metaevaluador (ver funcion)
			}
		$this->load->view('metaevaluacion_list', $data);
		}
		$this->load->view('template/footer');
	}

}

/* End of file metaevaluar.php */
/* Location: ./application/controllers/metaevaluar.php */

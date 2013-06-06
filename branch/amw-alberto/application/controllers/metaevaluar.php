<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metaevaluar extends CI_Controller {	
	
	public function index2(){

		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		
		$this->metaevaluaciones->reload(); // Busca evaluaciones que no hayan sido metaevaluadas y crea sus metaevaluaciones
		$id = $this->session->userdata('userid');

		$filtro = $this->metaevaluaciones->metavaluaciones_para_aumno($id);
		$por_metaevaluar = $this->metaevaluaciones->para_metaevaluar();
		$metaevaluadas = $this->metaevaluaciones->metaevaluadas();
		$realizadas = $this->metaevaluaciones->metaevaluaciones_realizadas($id);

		echo "Quedan por metaevaluar " . count($por_metaevaluar) . " evaluaciones <br>";
		echo "De las que quedan por metaevaluar " . count($filtro) . " no son evaluaciones ni ediciones mias <br>";
		echo "Han sido metaevaluadas " . count($metaevaluadas) . " evaluaciones <br>";
		echo "He echo: " . count($realizadas) . " metaevaluaciones <br>";


		$id = $this->metaevaluaciones->evaluacion_metaevaluada(44);


		echo "He metaevaluado: <br>";
		foreach ($realizadas as $key) {
			echo $key . "<br>";
		}
		
		echo "Por metaevaluar: <br>";
		foreach ($por_metaevaluar as $key) {
			echo $key . "<br>";
		}

		echo "Metaevaluadas: <br>";
		foreach ($metaevaluadas as $key) {
			echo $key . "<br>";	
		}	

	}

	public function index()
	{
		
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('Parametros_model', 'parametros');

		$this->metaevaluaciones->reload(); // Busca evaluaciones que no hayan sido metaevaluadas y crea sus metaevaluaciones
			
		$max_mevs = $this->parametros->get_evaluaciones_por_alumno(); // Numero de metaevaluaciones = numero de evaluaciones

		// Leemos el ID del usuario logueado
		$usuario_id = $this->session->userdata('userid');

		// Si el numero de evaluaciones para metaevaluar es mayor que 0
		$por_metaevaluar = $this->metaevaluaciones->para_metaevaluar();
		if (count($por_metaevaluar) > 0)
		{
			// Elegimos una de las metaevaluaciones de forma aleatoria
			$aleatorio = rand(0, (count($por_metaevaluar)-1));
			
			// Guardamos la id de la evaluacion elegida 
			$data['metaevaluacion'] = $por_metaevaluar[$aleatorio];
			
			// Obtenemos la id de la evaluacion que estamos metaevaluando
			$data['evaluacion'] = $this->metaevaluaciones->evaluacion_metaevaluada($data['metaevaluacion']);

			// Obtenemos la entrada evaluada que estamos metaevaluando
			$data['entrada'] = $this->metaevaluaciones->entrada_metaevaluada($data['metaevaluacion']);

			$evaluacion = $this->evaluaciones->consultar_entregables($data['evaluacion']);
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

		foreach ($data as $key => $value) {
			echo "Seguimiento de data: " . $key . "=> " . $value . "<br>";
		}
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


		$data['mevaluador_id'] = $this->session->userdata('userid'); // El metaevaluador sera el usuario logeado
		echo "Seguimiento del id del usuario logeado : " . $this->session->userdata('userid') . "<br>";
		
		// $data['evaluacion_id'] = $this->evaluaciones->id(); // La id de la evaluacion ha de permanecer como cuando se creo, para saber cual es

		$data['calificacion'] = $this->input->post('puntuacion'); // Leemos la nota que haya introducido el metaevaluador
		echo "Seguimiento de la calificacion : " . $this->input->post('puntuacion') . "<br>";
		
		$data['comentario'] = $this->input->post('descripcion'); // Leemos el comentario introducido
		echo "Seguimiento del comentario : " . $this->input->post('comentario') . "<br>";

		$this->metaevaluaciones->modificar($data); //esta funcion debe modificar los datos, no insertar
	}
}

/* End of file metaevaluar.php */
/* Location: ./application/controllers/metaevaluar.php */

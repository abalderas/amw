<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluar extends CI_Controller {

	
	public function index()
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Entregable_model', 'entregables');
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Revisiones_model', 'revisiones');
		
		// Máximo número de evaluaciones por alumno
		//  Si es 0 no se tiene en cuenta.
		$max_eval = 10;
		
		/* 
			Buscar una entrada válida:		
			a) Tiene que existir el identificador en la tabla revision.
			b) No debe haberse revisado ya.

		*/
		// Obtenemos las entradas ya revisadas.
		$entradas_existentes = $this->evaluaciones->listado();
		
		$usuario_id = $this->session->userdata('userid');
		// Obtenemos las entradas desterrando las que ya no valen.
		$entradas_validas = $this->revisiones->listado_validas($entradas_existentes, $usuario_id);
		
		if (sizeof($entradas_validas)>0)
		{
			//echo "Entradas validas: " . sizeof($entradas_validas) . "<br />";
			//print_r($entradas_validas);
			$aleatorio = rand(0, (sizeof($entradas_validas)-1));
			//echo "<br />Aleatorio: " . $aleatorio . "<br />";
			$data['entrada'] = $entradas_validas[$aleatorio];
		
			$data['usuario_a_revisar'] = $this->revisiones->usuarioArticulo($data['entrada']);
			//echo $data['usuario_a_revisar'];
			$data['campos'] = $this->entregables->entregables;
		}
		
		if ($max_eval>0)
		{
			$data['evaluaciones_pendientes'] = $max_eval - $this->revisiones->realizadas($usuario_id);
		}
		$data['usuario'] = $this->session->userdata('username');
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('previa_revision', $data);
		$this->load->view('template/footer');
	}

	public function procesar()
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Entregable_model', 'entregables');
		$this->load->model('Evaluaciones_model', 'evaluacion');
		
		
		$data['usuario'] = $this->session->userdata('username');
		$data['idusuario'] = $this->session->userdata('userid');
		$data['puntuacion'] = $this->input->post('puntuacion');
		$data['usuario_a_revisar'] = $this->input->post('user_id');
		$data['id_campo'] = $this->input->post('campo');
		$data['comentarios'] = $this->input->post('descripcion');
		$data['entrada'] = $this->input->post('entrada');
		
		$data['entregables'] = $this->entregables->entregables;
		
		/*
			Almaceno los datos que irán en la BD.
		*/
		
		$datos['eva_revisor'] = $data['idusuario'];
		$datos['eva_user'] = $data['usuario_a_revisar'];
		$datos['eva_revision'] = $data['entrada'];
		$this->evaluacion->insertar($datos);
		$this->evaluacion->insertar_entregables($data['id_campo'], 
		$data['puntuacion'], $data['comentarios']);
		
		
		$this->mostrar_evaluacion($this->evaluacion->id());

	}
	
	function mostrar_evaluacion($evaluacion = 0)
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');
		
		if ($evaluacion == 0)
			redirect('acceso/index');
			
		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		$this->load->model('evaluaciones_model', 'evaluacion');
		$this->load->model('acceso_model', 'usuario');		
		$this->load->model('Usuarios_model', 'admin'); // Para ver si admin
		
		// id user logueado
		$usuario_id = $this->session->userdata('userid');
		
		$data = $this->evaluacion->consultar_entregables($evaluacion);
		
		
		// Si no es una evaluación propia
		//  Y no es el admin
		//   Lo echo.
		if ($data['usuario']!=$usuario_id&&$data['revisor']!=$usuario_id)
			if(!$this->admin->admin($usuario_id))
				redirect('evaluar');
		
		// A partir del id de usuario obtengo el nombre.
		$data['usuario'] = $this->usuario->username($data['usuario']);
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('info_revision', $data);
		$this->load->view('template/footer');
	}

}

/* End of file evaluar.php */
/* Location: ./application/controllers/evaluar.php */

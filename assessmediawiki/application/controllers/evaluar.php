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

		// Leemos el ID del usuario logueado
		$usuario_id = $this->session->userdata('userid');

		// Obtenemos las entradas desterrando las que ya no valen.
		$entradas_validas = $this->revisiones->listado_validas($entradas_existentes, $usuario_id);

		// Si el numero de revisiones evaluables es mayor que 0
		if (sizeof($entradas_validas)>0)
		{
			// Elegimos una de las entradas de forma aleatoria
			$aleatorio = rand(0, (sizeof($entradas_validas)-1));
			
			// Guardamos la entrada elegida 
			$data['entrada'] = $entradas_validas[$aleatorio];
		
			// Leemos el autor de la entrada a revisar
			$data['usuario_a_revisar'] = $this->revisiones->usuarioArticulo($data['entrada']);
			
			// Pasamos los títulos y las descripciones de los campos a evaluar
			$data['campos'] = $this->entregables->entregables;
			$data['descriptions'] = $this->entregables->descriptions;
		}
		
		if ($max_eval>0)
		{
			// Calculamos el número de evaluaciones que aún debe hacer el usuario
			$data['evaluaciones_pendientes'] = $max_eval - $this->revisiones->realizadas($usuario_id);
		}

		$data['usuario'] = $this->session->userdata('username');
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('emw_title');

		// Si finalmente hay alguna entrada a evaluar
		if (isset($data['entrada']))
		{
			$data['msg'] = "You may grade the revision here below.";
			$data['post_url'] = 'evaluar/procesar';
			$this->load->view('hello_revision', $data);
			$this->load->view('previa_revision');
		}

		// Si no hay ninguna revisión a evaluar
		else
		{			
			$this->load->view('no_revision', $data);
		}

		$this->load->view('template/footer');
	}

	/// Recibe los datos provenientes del formulario de evaluación y los añade a la base de datos
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
	
	/// Muestra la información relacionada con una evaluación
	function mostrar_evaluacion($eval = 0)
	{				
		$colors = array("#99C68E", "#F9966B", "#FDD017", "#EBDDE2", "#5CB3FF", "#736F6E");
		$this->load->model('Reply_model', 'reply');		
		$this->load->model('Usuarios_model', 'usuarios');
		
		
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		
		$data = $this->evaluation_data($eval);
		$data['usuario_id'] = $this->session->userdata('userid');
		$this->load->view('info_revision', $data);
		
		 // Replies
		$re_list = $this->reply->replies_list($eval);
		$tot = count($re_list);
		$tot_col = count($colors);
		for ($i = 0; $i < $tot; $i++)
		{
//			echo $re_list[$i] . "<br>";
			$data = $this->evaluation_data($re_list[$i]);
			$data['color'] = $colors[$i%$tot_col];
			$data['reply_number'] = $i+1;
			$this->load->view('info_revision', $data);
		}
		$this->load->view('emw_reply');
		$this->load->view('template/footer');
	}

	/// Muestra el formulario para añadir meta-evaluaciones (replies)
	function reply($evaluacion)

	{
		$this->load->model('Usuarios_model','usuarios');
		$data = $this->evaluation_data($evaluacion);
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$data['msg'] = "Please give us your assessment about your revision.";
		$data['usuario_id'] = $this->session->userdata('userid');
		$this->load->view('info_revision', $data);

		$this->load->view('reply_title');
		$this->load->model('Revisiones_model', 'revisiones');
		$data['usuario_a_revisar'] = $this->revisiones->usuarioArticulo($data['entrada']);  // Poner bien documento a evaluar (2874, no id de la evaluacion
		$this->load->model('Entregable_model', 'entregables');
		$data['campos'] = $this->entregables->entregables;
		$data['descriptions'] = $this->entregables->descriptions;
		$data['post_url'] = 'evaluar/reply_submit';
		$this->load->view('previa_revision', $data);
		$this->load->view('template/footer');
	}
	
	private function evaluation_data($evaluacion)
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
		// print_r($data);	
		// echo $evaluacion . "--ev<br>";
		
		// Si no es una evaluación propia
		//  Y no es el admin
		//   Lo echo.
		if ($data['usuario']!=$usuario_id&&$data['revisor']!=$usuario_id)
			if(!$this->admin->admin($usuario_id))
				redirect('evaluar');
		
		// A partir del id de usuario obtengo el nombre.
		$data['usuario'] = $this->usuario->username($data['usuario']);
		$data['evaluacion'] = $evaluacion;
        $data['revisor'] = $this->usuario->username($data['revisor']);
        //echo $data['revisor'];
		
		return $data;
	}
	
	function reply_submit()
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Entregable_model', 'entregables');
		$this->load->model('Evaluaciones_model', 'evaluacion');
		$this->load->model('Reply_model', 'reply');
		
		
		$data['usuario'] = $this->session->userdata('username');
		$data['idusuario'] = $this->session->userdata('userid');
		$data['puntuacion'] = $this->input->post('puntuacion');
		$data['time'] = time() - $this->input->post('time');
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
		$datos['eva_time'] = $data['time'];
		$this->evaluacion->insertar($datos);
		$this->evaluacion->insertar_entregables($data['id_campo'], 
		$data['puntuacion'], $data['comentarios']);
		
		$data_reply['rep_read'] = $this->input->post('rep_read');;
		$data_reply['rep_new'] = $this->evaluacion->id();
		$reply = new $this->reply();
		$reply->insert($data_reply);
		
		$this->mostrar_evaluacion($this->evaluacion->id());

	}

}

/* End of file evaluar.php */
/* Location: ./application/controllers/evaluar.php */

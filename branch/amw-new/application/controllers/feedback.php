<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends CI_Controller {

	
	public function index($id = 1)
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('revisiones_model', 'revisiones');
		$this->load->model('evaluaciones_model', 'evaluaciones');		
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Reply_model', 'replies');
		$this->load->model('Roles_model', 'roles');
		
		$usuario_id = $this->session->userdata('userid');	

		if ($id!=0)
			if (!$this->roles->es_admin($usuario_id))
				$id = 0; // Si no es admin sólo puede ver lo suyo.

		if ($id == 0)
			$id = $usuario_id;
		
		$articulos = $this->revisiones->articulos($id);
		$data['articulos'] = $this->evaluaciones->evaluados($articulos);	


		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('feedbacks', $data);
		$this->load->view('template/footer');
	}
	
	function informe($id)
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		$this->index($id);
	}
	
	function csv($id)
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');
	
		$this->load->model('Csv_model', 'csv');
		
		$data = $this->csv->datos($id);
		$data['entregables'] = $this->csv->entregables('ent_id');
		$data['notas'] = $this->csv->notas($data['listado']);
		
		$this->load->view('csv_view', $data);		
		
		

		// $id es el usuario a revisar (eva_user).
		/*
			SELECT eva_id
			FROM evaluaciones
			FROM eva_user = $id;
		*/
	}

	function csv_sheet($sheet)
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		$this->load->model('Csv_model', 'csv');
		$this->load->model('acceso_model', 'acceso');

		$data['wikiu'] = $this->acceso->usuarios();

		// Listado usuarios
		$data['users'] = $this->csv->usuarios();

		// Listado competencias
		$data['competencies'] = $this->csv->entregables('ent_id');

		if ($sheet==1) // Suma notas
			$data['sumas'] = $this->csv->suma_notas($data['users'], $data['competencies']);
		else if ($sheet==2) // Cuenta notas
			$data['sumas'] = $this->csv->cuenta_notas($data['users'], $data['competencies']);
		else if ($sheet==3)
			$data['sumas'] = $this->csv->resumen_notas($data['users'], $data['competencies']);


		$this->load->view('csv_sheet', $data);
	}

	// Funcion que muestra todas las metaevaluaciones que ha recibido un alumno
	function metaevaluaciones_recibidas($id)
	{
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Acceso_model', 'acceso');

		$this->load->view('template/header');
		$this->load->view('template/menu');	

		$data['metaevaluacion'] = $this->metaevaluaciones->metaevaluaciones_recibidas($id);

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
			$data['usuario'][$value] = $usuarios[$data['usuario_id'][$value]]; // Nombre del metaevaluador
			$data['evaluador_id'][$value] = $this->metaevaluaciones->evaluador_metaevaluada($data['evaluacion'][$value]); // ID del evaluador de la evaluacion metaevaluada
			$data['evaluador'][$value] = $usuarios[$data['evaluador_id'][$value]]; // Nombre del evaluador
		}
		$this->load->view('metaevaluacion_list', $data);
		$this->load->view('template/footer');
	}

	// Funcion que muestra todas las metaevaluaciones que ha recibido un alumno
	function metaevaluaciones_realizadas($id)
	{
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Acceso_model', 'acceso');

		$this->load->view('template/header');
		$this->load->view('template/menu');	

		$data['metaevaluacion'] = $this->metaevaluaciones->metaevaluaciones_realizadas($id);

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
			$data['usuario'][$value] = $usuarios[$data['usuario_id'][$value]]; // Nombre del metaevaluador
			$data['evaluador_id'][$value] = $this->metaevaluaciones->evaluador_metaevaluada($data['evaluacion'][$value]); // ID del evaluador de la evaluacion metaevaluada
			$data['evaluador'][$value] = $usuarios[$data['evaluador_id'][$value]]; // Nombre del evaluador
		}
		$this->load->view('metaevaluacion_list', $data);
		$this->load->view('template/footer');
	}

	// Funcion que dado un id muestra informacion variada sobre las metaevaluaciones y el resultado
	function resume ($id)
	{
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Acceso_model', 'acceso');

		$this->load->view('template/header');
		$this->load->view('template/menu');	

		$usuarios = $this->acceso->usuarios();
		$data['alumnos']=$usuarios[$id];
		$data['id']=$id;

		$data['media']=0;

		$data['metaevaluacion'] = $this->metaevaluaciones->metaevaluaciones_realizadas($id);

		$data['total'] = count($data['metaevaluacion']);
		$usuarios = $this->acceso->usuarios();


		$this->load->view('metaevaluacion_resume', $data);
		$this->load->view('template/footer');
	}
}

/* End of file feedback.php */
/* Location: ./application/controllers/feedback.php */


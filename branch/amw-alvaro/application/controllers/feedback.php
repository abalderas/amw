<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends CI_Controller {

	
	public function index($id = 0)
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
		
		$usuario_id = $this->session->userdata('userid');		

		if ($id!=0)
			if (!$this->acceso->es_admin($usuario_id))
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
	
	function replies($status = false)
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');
		
		$this->load->model('reply_model');
		$this->load->model('acceso_model');
		$this->load->model('roles_model');
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		
		if(!$status)
			$this->load->view('reply_list', array('replies' => $this->reply_model->student_replies_list()));
		else if($status == 'arbitred')
			$this->load->view('reply_list', array('replies' => $this->reply_model->arbitred_replies()));
		else
			$this->load->view('reply_list', array('replies' => $this->reply_model->nonarbitred_replies()));
			
		$this->load->view('template/footer');
	}
	
	function replies_in($student = false)
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		$this->load->model('reply_model');
		$this->load->model('acceso_model');
		$this->load->model('roles_model');

		$this->load->view('template/header');
		$this->load->view('template/menu');
		
		if($student)
			$this->load->view('reply_list', array('student' => $student, 'replies' => $this->reply_model->student_replies_list($student)));
		else
			$this->load->view('reply_list', array('replies' => $this->reply_model->student_replies_list()));
		
		
		$this->load->view('template/footer');
	}
	
	function replies_out($student = false)
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		$this->load->model('reply_model');
		$this->load->model('acceso_model');
		$this->load->model('roles_model');

		$this->load->view('template/header');
		$this->load->view('template/menu');
		
		if($student)
			$this->load->view('reply_list', array('student' => $student, 'replies' => $this->reply_model->student_replies_out_list($student)));
		else
			$this->load->view('reply_list', array('replies' => $this->reply_model->student_replies_out_list()));
		
		
		$this->load->view('template/footer');
	}
}

/* End of file feedback.php */
/* Location: ./application/controllers/feedback.php */


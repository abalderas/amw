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
		$this->load->model('Usuarios_model', 'usuarios');
		
		$usuario_id = $this->session->userdata('userid');		

		if ($id!=0)
			if (!$this->usuarios->admin($usuario_id))
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
		$this->index($id);
	}


}

/* End of file evaluar.php */
/* Location: ./application/controllers/feedback.php */


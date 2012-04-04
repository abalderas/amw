<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alumnos extends CI_Controller {

	
	public function index()
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');
		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Usuarios_model', 'usuarios');
		$usuario_id = $this->session->userdata('userid');
		//$usuario_id = 2;
		if (!$this->usuarios->admin($usuario_id))
			redirect('evaluar');

		$data['alumnos'] = $this->usuarios->usuarios;
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('alumnos', $data);
		$this->load->view('template/footer');
	}


}

/* End of file evaluar.php */
/* Location: ./application/controllers/alumnos.php */

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuration extends CI_Controller {	
	
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		
		$this->load->model('acceso_model');
		$this->load->model('roles_model');
	}
    
	public function index(){
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');		
	}
	
	public function setroles($role = false){
		$alumnos = $this->acceso_model->usuarios();
		
		if(!$role)
			foreach($alumnos as $key => $value)
				$final_roles[] = array('role_user' => $value, 'role_name' => $this->input->post("select_role_$key"));
		else if($role == 'student')
			foreach($alumnos as $key => $value)
				$final_roles[] = array('role_user' => $value, 'role_name' => 'student');
		else if($role == 'referee')
			foreach($alumnos as $key => $value)
				$final_roles[] = array('role_user' => $value, 'role_name' => 'referee');
		else if($role == 'meta')
			foreach($alumnos as $key => $value)
				$final_roles[] = array('role_user' => $value, 'role_name' => 'meta');
		else if($role == 'metameta')
			foreach($alumnos as $key => $value)
				$final_roles[] = array('role_user' => $value, 'role_name' => 'metameta');
		
		$this->roles_model->saveroles($final_roles);
		
		$data['alumnos'] = $this->acceso_model->usuarios();	
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('alumnos', $data);
		$this->load->view('template/footer');
	}
}

/* End of file evaluar.php */
/* Location: ./application/controllers/evaluar.php */

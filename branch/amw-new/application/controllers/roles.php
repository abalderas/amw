<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends CI_Controller {

public function index()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		// LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');

		// Leemos el ID del usuario que ha hecho login
		$usuario_id = $this->session->userdata('userid');
		
		// Si el usuario tiene permisos, lo sacamos de aquí
		if (!$this->roles->comprobar_permisos($usuario_id,'parametros'))
			redirect('evaluar');

		// Leemos los datos de los alumnos
		$data['alumnos'] = $this->acceso->usuarios();
		$data['roles'] = $this->roles->get_rol_list();
		foreach ($data['roles'] as $rol => $name) {
			$data['evaluar'][$name] = $this->roles->comprobar_permisos_de_rol($name, 'evaluar');
			$data['feedback'][$name] = $this->roles->comprobar_permisos_de_rol($name, 'feedback');
			$data['metaevaluar'][$name] = $this->roles->comprobar_permisos_de_rol($name, 'metaevaluar');
			$data['metaevaluar_lista'][$name] = $this->roles->comprobar_permisos_de_rol($name, 'metaevaluar_lista');
			$data['alumnos'][$name] = $this->roles->comprobar_permisos_de_rol($name, 'alumnos');
			$data['parametros'][$name] = $this->roles->comprobar_permisos_de_rol($name, 'parametros');
		}
		$data['usuarios_con_roles'] = $this->roles->usuarios_con_roles();
		foreach ($data['usuarios_con_roles'] as $key => $value) {
			$data["username"][$value] = $data['alumnos'][$value];
			$data["userrol"][$value] = $this->roles->get_rol($value);
		}
		$data['new_rol_url'] = 'roles/create_rol';
		$data['edit_rol_url'] = 'roles/edit_rol';
		$data['delete_rol_url'] = 'roles/delete_rol';
		$data['assign_rol_url'] = 'roles/assign_rol';

		// Cargamos las vistas
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('roles', $data);
		$this->load->view('template/footer');
	}

	public function create_rol()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');

		//Si se ha mantenido el mensaje por fefecto del cuadro de texto entenderemos que le han dado al boton sin querer
		if ($this->input->post('new_rol_name') == "New rol name")
			redirect('roles');
		
		//Leemos el nuevo nombre del rol y los nuevos permisos
		else 
		{	
			$datos['name'] = $this->input->post('new_rol_name'); 
			
			if ($this->input->post('nuevo_acceso') == 'on')
				$datos['evaluar'] = true;
			
			if ($this->input->post('nuevo_feedback') == 'on')
				$datos['feedback'] = true;
	
			if ($this->input->post('nuevo_metaevaluaciones') == 'on')
				$datos['metaevaluar'] = true;
			
			if ($this->input->post('metaevaluaciones_lista') == 'on')
				$datos['metaevaluar_lista'] = true;
			
			if ($this->input->post('nuevo_alumnos') == 'on')
				$datos['alumnos'] = true;
			
			if ($this->input->post('nuevo_parametros') == 'on')
				$datos['parametros'] = true;
	
			$this->roles->insertar_rol($datos);
		}
		redirect('roles');
	}

	public function delete_rol()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');

		$rol=$this->input->post('rol_to_delete');
		
		$this->roles->eliminar_rol($rol);

		redirect('roles');
	}

	public function edit_rol()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');

		$datos['name'] = $this->input->post('rol_name');
		//$datos['name'] = $_POST['rol_name'];

		if ($this->input->post('evaluar') == 'on')
			$datos['evaluar'] = true;
		
		if ($this->input->post('nuevo_feedback') == 'on')
			$datos['feedback'] = true;

		if ($this->input->post('nuevo_metaevaluaciones') == 'on')
			$datos['metaevaluar'] = true;
		
		if ($this->input->post('metaevaluaciones_lista') == 'on')
			$datos['metaevaluar_lista'] = true;
		
		if ($this->input->post('nuevo_alumnos') == 'on')
			$datos['alumnos'] = true;
		
		if ($this->input->post('nuevo_parametros') == 'on')
			$datos['parametros'] = true;

		$this->roles->modificar_rol($datos);

		redirect('roles');
	}

	public function assign_rol()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');

		$user= $this->input->post('user_to_assign') 
		$rol= $this->input->post('rol_to_assign')

		if ($rol == 'Student') //Si el rol es alumno se elimina directamente de la tabla
		{
			$this->roles->desasignar_rol($user);
		}
		else
		{
			$this->roles->asignar_rol($user, $rol);
		}
		
		redirect('roles');
	}

}
/* End of file acceso.php */
/* Location: ./application/controllers/roles.php */

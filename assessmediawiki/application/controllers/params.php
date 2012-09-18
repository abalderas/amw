<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Params extends CI_Controller {

	function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
		
		// Comprobamos que el usuario ha hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		// Cargamos las bibliotecas necesarias
        $this->load->library(array('encrypt', 'form_validation'));
		
		// Cargamos el modelo de usuarios
		$this->load->model('Usuarios_model', 'usuarios');
		$usuario_id = $this->session->userdata('userid');
		
		// Restringimos el acceso a administradores
		if (!$this->usuarios->admin($usuario_id))
			redirect('evaluar');

		// Cargamos los modelos de los datos
		$this->load->model('Test_model', 'tests');
		$this->load->model('Parametros_model', 'parametros');
		
    }
	
	public function index()
	{
		$this->load->helper('url');
		$this->load->helper('html');		

		$data['tests'] = $this->tests->tests;

		// Si se han recibido datos del formulario de parámetros
		if ($this->input->post('categoria'))
		{
			$this->parametros->set_categoria($this->input->post('categoria'));
			$this->parametros->set_fecha_inicio($this->input->post('fecha_inicio'));
			$this->parametros->set_fecha_fin($this->input->post('fecha_fin'));
		}

		// Leemos la categoría
		$data['categoria'] = $this->parametros->get_categoria();
		$data['fecha_inicio'] = $this->parametros->get_fecha_inicio();
		$data['fecha_fin'] = $this->parametros->get_fecha_fin();
		
		$this->load->view('template/header');
		$this->load->view('template/header-delete');
		$this->load->view('template/menu');
		$this->load->view('tests', $data);
		$this->load->view('template/footer');
	}
	
	public function delete($id)
	{		
		$this->tests->delete($id);
		redirect('params');
	}
	
	public function edit($id)
	{
		$data['id'] = array(
              'ent_id'  => $id);
		
		$this->load->helper('form');
		$this->load->helper('html');		
		
		$data['test'] = array(
              'name'        => 'ent_entregable',
              'id'          => 'ent_entregable',
              'value'       => $this->tests->edit($id)->ent_entregable,
              'maxlength'   => '100',
              'size'        => '30',
              'style'       => 'width:30%',
            );	
		$data['description'] = array(
              'name'        => 'ent_description',
              'id'          => 'ent_description',
              'value'       => $this->tests->edit($id)->ent_description,
              'maxlength'   => '100',
              'size'        => '30',
              'style'       => 'width:30%',
            );	
      $data['submit'] = array(
      		'value' => 'Submit');	
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('tests-edit', $data);
		$this->load->view('template/footer');
	}
	
	public function update()
	{
		$data = $this->input->post();
		$this->tests->update($data);
		redirect('params/index');
	}
	
	public function add()
	{
		$this->load->helper('form');
		$this->load->helper('html');		
		
		$data['test'] = array(
              'name'        => 'ent_entregable',
              'id'          => 'ent_entregable',
              'maxlength'   => '100',
              'size'        => '30',
              'style'       => 'width:30%',
            );			
		
		$data['description'] = array(
              'name'        => 'ent_description',
              'id'          => 'ent_description',
              'maxlength'   => '100',
              'size'        => '30',
              'style'       => 'width:30%',
            );	
      $data['submit'] = array(
      		'value' => 'Submit');	
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('tests-new', $data);
		$this->load->view('template/footer');
	}
	
	public function insert()
	{
		$data = $this->input->post();
		$this->tests->insert($data);
		redirect('params/index');
	}

	function csv()
	{
		
		$this->load->model('Csv_model', 'csv');
		
		$data['id'] = $this->csv->entregables('ent_id');
		$data['ent'] = $this->csv->entregables('ent_entregable');
		
		$this->load->view('csv_params_view', $data);		
		
	}


}

/* End of file evaluar.php */
/* Location: ./application/controllers/alumnos.php */

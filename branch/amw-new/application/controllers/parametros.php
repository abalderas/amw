<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parametros extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		
		// Comprobamos que el usuario ha hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		// Cargamos las bibliotecas necesarias
        $this->load->library(array('encrypt', 'form_validation'));
		
		// Cargamos el modelo de usuarios
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('roles_model', 'roles');
		$usuario_id = $this->session->userdata('userid');
		
		// Restringimos el acceso a administradores
		if (!$this->roles->es_admin($usuario_id))
			redirect('evaluar');

		// Cargamos los modelos de los datos
		$this->load->model('Entregable_model', 'entregable');
		$this->load->model('Parametros_model', 'parametros');
    }
	
	public function index()
	{
		// Leemos todos los entregables
		$data['entregables'] = $this->entregable->entregables;
		foreach ($data['entregables'] as $key => $value) {
			$data['generic_specific'][$value] = $this->entregable->get_generic_specific($value);
		}

		// Si se han recibido datos del formulario de parámetros
		if ($this->input->post('categoria') || $this->input->post('fecha_inicio') || $this->input->post('fecha_fin'))
		{
			$this->parametros->set_categoria($this->input->post('categoria'));
			$this->parametros->set_fecha_inicio($this->input->post('fecha_inicio'));
			$this->parametros->set_fecha_fin($this->input->post('fecha_fin'));
			$this->parametros->set_evaluaciones_por_alumno($this->input->post('evaluaciones_por_alumno'));
			$this->parametros->set_metaevaluaciones_por_alumno($this->input->post('metaevaluaciones_por_alumno'));
			$this->parametros->set_evaluaciones_por_edicion($this->input->post('evaluaciones_por_edicion'));
			$this->parametros->set_min_ediciones_evaluadas_por_alumno($this->input->post('min_ediciones_evaluadas_por_alumno'));
			$this->parametros->set_autoevaluacion($this->input->post('autoevaluacion'));


			$wiki_url = $this->input->post('wiki_url');
			// Añade una barra invertida si no la trae al final
			if (substr($wiki_url, -1) != "/") 
			{
				$wiki_url .= "/";
			}

			$this->parametros->set_wiki_url($wiki_url);
		}

		// Leemos la categoría
		$data['categoria'] = $this->parametros->get_categoria();
		$data['fecha_inicio'] = $this->parametros->get_fecha_inicio();
		$data['fecha_fin'] = $this->parametros->get_fecha_fin();
		$data['evaluaciones_por_alumno'] = $this->parametros->get_evaluaciones_por_alumno();
		$data['metaevaluaciones_por_alumno'] = $this->parametros->get_metaevaluaciones_por_alumno();
		$data['evaluaciones_por_edicion'] = $this->parametros->get_evaluaciones_por_edicion();
		$data['min_ediciones_evaluadas_por_alumno'] = $this->parametros->get_min_ediciones_evaluadas_por_alumno();
		$data['autoevaluacion'] = $this->parametros->get_autoevaluacion();
		$data['wiki_url'] = $this->parametros->get_wiki_url();
		
		$this->load->view('template/header');
		$this->load->view('template/header-delete');
		$this->load->view('template/menu');
		$this->load->view('parametros', $data);
		$this->load->view('template/footer');
	}
	
	/// Borra el entregable indicado
	public function delete($id)
	{		
		$this->entregable->delete($id);
		redirect('parametros');
	}
	
	/// Lanza el formulario de edición de entregable
	public function edit($id)
	{
		// Poblamos los campos de la vista
		$data['modo'] = 'update';
		$data['titulo'] = 'Input the new data for the criteria';

		$data['ent_id'] = $id;

		$data['ent_entregable'] = array(
			'name' => 'ent_entregable', 
			'value' => $this->entregable->entregables[$id]);

		$data['generic_specific'] = array(
			'name' => 'generic_specific', 
        'value' => $this->entregable->generic_specific[$id]);

		$data['ent_description'] = array(
			'name' => 'ent_description',
			'class' => 'input-xxlarge',
			'value' => $this->entregable->descriptions[$id]);
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('entregable_formulario', $data);
		$this->load->view('template/footer');
	}
	
	/// Confirma la modificación del entregable
	public function update()
	{
		$data = $this->input->post();
		$this->entregable->update($data);
		redirect('parametros/index');
	}
	
	public function add()
	{
		// Poblamos los campos de la vista
		$data['modo'] = 'insert';
		$data['titulo'] = 'Input the data for the new criteria';

		$data['ent_entregable'] = array(
              'name'        => 'ent_entregable',
              'id'          => 'ent_entregable',
            );		

        $data['generic_specific'] = array(
              'name'        => 'generic_specific',
              'id'          => 'generic_specific',
            );		
		
		$data['ent_description'] = array(
              'name'        => 'ent_description',
              'id'          => 'ent_description',
            );	
		
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('entregable_formulario', $data);
		$this->load->view('template/footer');
	}
	
	public function insert()
	{
		$data = $this->input->post();
		$this->entregable->insert($data);
		redirect('parametros/index');
	}

	function csv()
	{
		
		$this->load->model('Csv_model', 'csv');
		
		$data['id'] = $this->csv->entregables('ent_id');
		$data['ent'] = $this->csv->entregables('ent_entregable');
		
		$this->load->view('csv_parametros_view', $data);		
		
	}

	function help()
	{
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('help');
		$this->load->view('template/footer');
	}
}

/* End of file evaluar.php */
/* Location: ./application/controllers/alumnos.php */

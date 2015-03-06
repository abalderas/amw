<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller 
{	

	public function index()
	{
		redirect('test/acceso');
	}

	public function acceso()
	{
		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('csv_model', 'csv');
		$this->load->model('entregable_model', 'entregable');
		$this->load->model('evaluaciones_model', 'evaluaciones');
		$this->load->model('metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('parametros_model', 'parametros');
		$this->load->model('reply_model', 'reply');
		$this->load->model('revisiones_model', 'revisiones');

		$userid = $this->session->userdata('userid');
		echo 'Bienvenido a la zona de test usuario numero ' . $userid . '<br><br>';
		print_r($this->session->userdata);
		echo "<br><br>";

		foreach ($this->session->userdata as $key => $value) 
		{
			echo $key . "--->" . $value . "<br>";
		}
		echo "<br><br>";

		echo $this->acceso->get_rol($userid) . "<br>";

		echo "Comprobacion de accesos: <br>";
		$accesos = array(
							'evaluar_access' => $this->acceso->comprobar_permisos($userid, 'evaluar'),
							'feedback_access' => $this->acceso->comprobar_permisos($userid, 'feedback'),
							'metaevaluar_access' => $this->acceso->comprobar_permisos($userid, 'metaevaluar'),
							'metaevaluar_lista_access' => $this->acceso->comprobar_permisos($userid, 'metaevaluar_lista'),
							'alumnos_access' => $this->acceso->comprobar_permisos($userid, 'alumnos'),
							'parametros' => $this->acceso->comprobar_permisos($userid, 'parametros')
							);
		foreach ($accesos as $key => $value) 
		{
			echo $key . "--->" . $value . "<br>";
		}
		echo "<br>";

		echo "Lista de id de roles <br>";
		$rol_id_list = $this->acceso->get_rol_id_list();
		foreach ($rol_id_list  as $key => $value) {
			echo $key . "--->" . $value . "<br>";
		}

		echo "<br>";

		echo "Lista de nombres roles <br>";
		$rol_list = $this->acceso->get_rol_list();
		foreach ($rol_list  as $key => $value) {
			echo $key . "--->" . $value . "<br>";
		}

		echo "<br> El usuario actual:" . $this->session->userdata["username"] . " ";
		if ($this->roles->es_admin($userid)) {
			echo "ES ADMIN! <br>";
		}
		if (!$this->roles->es_admin($userid)) {
			echo "NO ES ADMIN! <br>";
		}
	}

	public function testdata($data) 
	{
		foreach ($data as $key => $value) {
			echo $key . "--->" . $value . "<br>";
		}
	}
	
	public function metaevaluar()
	{
		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('Evaluaciones_model', 'evaluaciones');
		$this->load->model('Metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('acceso_model', 'acceso');
		
		$id = $this->session->userdata('userid');

		$filtro = $this->metaevaluaciones->metavaluaciones_para_aumno($id);
		$por_metaevaluar = $this->metaevaluaciones->para_metaevaluar();
		$metaevaluadas = $this->metaevaluaciones->listado_metaevaluadas();
		$realizadas = $this->metaevaluaciones->metaevaluaciones_realizadas($id);

		echo "Quedan por metaevaluar " . count($por_metaevaluar) . " evaluaciones <br>";
		echo "De las que quedan por metaevaluar " . count($filtro) . " no son evaluaciones ni ediciones mias <br>";
		echo "Han sido metaevaluadas " . count($metaevaluadas) . " evaluaciones <br>";
		echo "He echo: " . count($realizadas) . " metaevaluaciones <br>";


		// $id = $this->metaevaluaciones->evaluacion_metaevaluada(0);


		echo "He metaevaluado: <br>";
		foreach ($realizadas as $key) {
			echo $key . "<br>";
		}
		
		echo "Por metaevaluar: <br>";
		foreach ($por_metaevaluar as $key) {
			echo $key . "<br>";
		}

				echo "Para alumno logeado: <br>";
		foreach ($filtro as $key) {
			echo $key . "<br>";	
		}	

		echo "Metaevaluadas: <br>";
		foreach ($metaevaluadas as $key) {
			echo $key . "<br>";	
		}
	}

	public function general()
	{
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('csv_model', 'csv');
		$this->load->model('entregable_model', 'entregable');
		$this->load->model('evaluaciones_model', 'evaluaciones');
		$this->load->model('metaevaluaciones_model', 'metaevaluaciones');
		$this->load->model('parametros_model', 'parametros');
		$this->load->model('reply_model', 'reply');
		$this->load->model('revisiones_model', 'revisiones');

		$userid = $this->session->userdata('userid');
		echo 'Bienvenido a la zona de test usuario numero ' . $userid . '<br><br>';
		print_r($this->session->userdata);
		echo "<br><br>";

		foreach ($this->session->userdata as $key => $value) 
		{
			echo $key . "--->" . $value . "<br>";
		}
		echo "<br><br>";
	}	
}



/* End of file Eest.php */
/* Location: ./application/controllers/test.php */
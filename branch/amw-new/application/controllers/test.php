<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller 
{	

	public function index()
	{
		redirect('test/rafagas');
	}

	public function show_msg()
	{
		echo 'Wellcome to the debug room, this file is allocated on ./application/controllers/test.php and is only accesible if "modo desarrollo" is set to true in .application\config\amw.php <br><br>';
	}

	public function testdata($data) 
	{
		foreach ($data as $key => $value) {
			echo $key . "--->" . $value . "<br>";
		}
	}

	public function base()
	{
		$this->show_msg();

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
		$this->load->model('roles_model', 'roles');
		$this->load->model('evaluation_exercise_model', 'evaluation_exercise');
	}

	public function rafagas()
	{
		$this->show_msg();

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
		$this->load->model('roles_model', 'roles');
		$this->load->model('evaluation_exercise_model', 'evaluation_exercise');

		$ee = 2;
		$this->evaluation_exercise->deteccion_de_rafagas($ee);
	}

	public function algoritmo_preasignacion()
	{
		$this->show_msg();

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
		$this->load->model('roles_model', 'roles');
		$this->load->model('evaluation_exercise_model', 'evaluation_exercise');

		$ee = 2;
		$evals_per_student = $this->parametros->get_evaluaciones_por_alumno();
		$evals_per_edition = $this->parametros->get_evaluaciones_por_edicion();
		$min_editions_eval = $this->parametros->get_min_ediciones_evaluadas_por_alumno();
		$autoevaluation = $this->parametros->get_autoevaluacion();
		$users = $this->evaluation_exercise->get_users_for_ee($ee);
		$revisions = $this->evaluation_exercise->get_revisions_for_ee($ee);
		
		$cuenta_users = count ($users);
		$cuenta_evals = count ($revisions);

		//$users = $this->evaluation_exercise->get_editions_of_ee($ee);

		echo "Evaluaciones por alumno: " . $evals_per_student . "<br>";
		echo "Evaluaciones por edicion: " . $evals_per_edition . "<br>";
		echo "Ediciones evaluadas por alumno: " . $min_editions_eval . "<br>";
		echo "Alumnos: " . $cuenta_users . "<br>";
		echo "Evaluaciones: " . $cuenta_evals . "<br>";
		echo "Autoevaluacion: " . $autoevaluation . "<br><br>";

		if ($min_editions_eval > 0)
		{
			$this->evaluation_exercise->preasignations_with_min ($users, $revisions, $ee, $evals_per_student, $evals_per_edition, $autoevaluation, $min_editions_eval);
			//$this->testdata($this->evaluation_exercise->preasignations_with_min ($users, $revisions, $ee, $evals_per_student, $autoevaluation, $evals_per_edition, $min_editions_eval));
		}
		else
		{	
			$this->evaluation_exercise->preasignations_no_min ($users, $revisions, $ee, $evals_per_student, $evals_per_edition, $autoevaluation);
		}
	}

	public function evaluation_exercises()
	{
		$this->show_msg();

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
		$this->load->model('roles_model', 'roles');
		$this->load->model('evaluation_exercise_model', 'evaluation_exercise');

		$userid = $this->session->userdata('userid');
		echo 'Bienvenido a la zona de test usuario numero ' . $userid . '<br><br>';
		print_r($this->session->userdata);
		echo "<br><br>";

		foreach ($this->session->userdata as $key => $value) 
		{
			echo $key . "--->" . $value . "<br>";
		}
		echo "<br><br>";

		$data['evaluation_exercise_id'] = $this->evaluation_exercise->get_ee_id_list();
		foreach ($data['evaluation_exercise_id'] as $evaluation_exercise => $id) {
			$data['exercise_name'][$id] = $this->evaluation_exercise->get_ee_name($id);
			$data['beginning'][$id] = $this->evaluation_exercise->get_ee_beginning($id);
			$data['first_phase_end'][$id] = $this->evaluation_exercise->get_ee_first_phase_end($id);
			$data['second_phase_end'][$id] = $this->evaluation_exercise->get_ee_second_phase_end($id);
			$data['third_phase_end'][$id] = $this->evaluation_exercise->get_ee_third_phase_end($id);
			$data['fourth_phase_end'][$id] = $this->evaluation_exercise->get_ee_fourth_phase_end($id);
			$data['description'][$id] = $this->evaluation_exercise->get_ee_description($id);
		}

		$data['entregables'] = array();
		$data['entregables'] = $this->entregable->get_entregable_list();
		foreach ($data['entregables'] as $key => $value) {
			$data['entregable_name'][$value]=$this->entregable->get_entregable_name($value);
		}
		foreach ($data['evaluation_exercise_id'] as $ee) {
			foreach ($data['entregables'] as $categoria) {
				$data['multiarray'][$ee][$categoria]=$this->entregable->check_entregable_on_ev_ex($ee, $categoria);
			}
		}
		
		foreach ($data as $key => $value) {
			echo $key . "<br>";
			foreach ($value as $subkey => $subvalue) {
				echo $subkey . "--->" . $subvalue . "<br>";
			}
			echo "<br>";
		}
		echo "<br><br><br><br>";

		print_r($data['multiarray']);

		echo "<br><br><br><br>";
		print_r($data);
	}
	
	public function roles()
	{
		$this->show_msg();

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
		$this->load->model('roles_model', 'roles');

		$userid = $this->session->userdata('userid');
		echo $this->roles->get_rol($userid) . "<br>";

		echo "Comprobacion de accesos: <br>";
		$accesos = array(
							'evaluar_access' => $this->roles->comprobar_permisos($userid, 'evaluar'),
							'feedback_access' => $this->roles->comprobar_permisos($userid, 'feedback'),
							'metaevaluar_access' => $this->roles->comprobar_permisos($userid, 'metaevaluar'),
							'metaevaluar_lista_access' => $this->roles->comprobar_permisos($userid, 'metaevaluar_lista'),
							'alumnos_access' => $this->roles->comprobar_permisos($userid, 'alumnos'),
							'parametros' => $this->roles->comprobar_permisos($userid, 'parametros')
							);
		foreach ($accesos as $key => $value) 
		{
			echo $key . "--->" . $value . "<br>";
		}
		echo "<br>";

		echo "Lista de roles <br>";
		$rol_list = $this->roles->get_rol_list();
		foreach ($rol_list  as $key => $value) {
			$rol_id = $this->roles->get_rol_id($value);
			$ammount = $this->roles->count_ammount_of_roles_assigned($rol_id);
			echo $key . " ---> " . "Nombre: ". $value . " ---> " . "ID: ". $rol_id . " ---> " . "Usuarios: ". $ammount . "<br>";
		}

		echo "<br>";

		echo "Lista de bombres de roles <br>";
		$rol_list = $this->roles->get_rol_list();
		foreach ($rol_list  as $key => $value) {
			echo $key . "--->" . $value . "<br>";
		}

		echo "<br>";

		echo "Lista de id de roles <br>";
		$rol_id_list = $this->roles->get_rol_id_list();
		foreach ($rol_id_list  as $key => $value) {
			echo $key . "--->" . $value . "<br>";
		}

		echo "<br>";

		echo "Cantidad de roles <br>";
		$rol_list = $this->roles->get_rol_list();
		foreach ($rol_list  as $key => $value) {
			$ammount = $this->roles->count_ammount_of_roles_assigned($this->roles->get_rol_id($value));
			echo $value . "--->" . $ammount . "<br>";
		}

		echo "<br> El usuario actual:" . $this->session->userdata["username"] . " ";
		if ($this->roles->es_admin($userid)) {
			echo "ES ADMIN! <br>";
		}
		if (!$this->roles->es_admin($userid)) {
			echo "NO ES ADMIN! <br>";
		}

		echo "Otros usuarios con el mismo rol:<br>";
		$user_rol = $this->roles->get_user_rol_id($userid);
		$samerol = $this->roles->get_users_with_rol($user_rol);
		foreach ($samerol  as $key => $value) 
		echo $key . "--->" . $value . "<br>";
	}

	public function metaevaluar()
	{
		$this->show_msg();

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
		$this->show_msg();

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
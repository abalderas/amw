<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluation_exercise extends CI_Controller {

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
		$this->load->model('Evaluation_exercise_model', 'evaluation_exercise');
		$this->load->model('entregable_model', 'entregable');

		// Leemos el ID del usuario que ha hecho login
		$usuario_id = $this->session->userdata('userid');
		
		// Si el usuario tiene permisos, lo sacamos de aquí
		if (!$this->roles->comprobar_permisos($usuario_id,'parametros'))
			redirect('evaluar');

		// Leemos los datos de los ejercicios de evaluacion
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

		$data['avalibles_for_preasignations'] = $this->evaluation_exercise->avalibles_for_preasignations();
		$data['preasignations_to_delete'] = $this->evaluation_exercise->get_ee_with_preasignations();

		//Tomamos los datos de las categorias a evaluar
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

		$data['new_evaluation_exercise_url'] = 'evaluation_exercise/create_evaluation_exercise';
		$data['edit_evaluation_exercise_criteria_url'] = 'evaluation_exercise/edit_evaluation_exercise_criteria';
		$data['edit_evaluation_exercise_url'] = 'evaluation_exercise/edit_evaluation_exercise';
		$data['delete_evaluation_exercise_url'] = 'evaluation_exercise/delete_evaluation_exercise';
		$data['make_preasignations_url'] = 'evaluation_exercise/make_preasignations';
		$data['delete_preasignations_url'] = 'evaluation_exercise/delete_preasignations';

		// Cargamos las vistas
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('evaluation_exercise', $data);
		$this->load->view('template/footer');
	}

	public function create_evaluation_exercise()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');
		$this->load->model('Evaluation_exercise_model', 'evaluation_exercise');

		//Si se ha mantenido el mensaje por fefecto del cuadro de texto entenderemos que le han dado al boton sin querer
		if ($this->input->post('new_evaluation_exercise_name') == "New_evaluation_exercise_name")
			redirect('evaluation_exercise');
		
		//Leemos el nuevo nombre del evaluation_exercise y los nuevos permisos
		else 
		{	
			$datos['exercise_name'] = $this->input->post('new_evaluation_exercise_name'); 
			$datos['beginning'] = $this->input->post('nuevo_beginning');
			$datos['first_phase_end'] = $this->input->post('nuevo_first_phase_end');
			$datos['second_phase_end'] = $this->input->post('nuevo_second_phase_end');
			$datos['third_phase_end'] = $this->input->post('nuevo_third_phase_end');
			$datos['fourth_phase_end'] = $this->input->post('nuevo_fourth_phase_end');
			$datos['description'] = $this->input->post('nuevo_description');
				
			$this->evaluation_exercise->insertar_evaluation_exercise($datos);
		}

		redirect('evaluation_exercise');
	}

	public function edit_evaluation_exercise_criteria()
	{
	// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');
		$this->load->model('Evaluation_exercise_model', 'evaluation_exercise');
		$this->load->model('entregable_model', 'entregable');
		

		$datos['evaluation_id'] = $this->evaluation_exercise->get_ee_id_list();
		$datos['ent_id'] = $this->entregable->get_entregable_list();
		foreach ($datos['ent_id'] as $value) {
			$entregable_name[$value]=$this->entregable->get_entregable_name($value);
		}

		foreach ($entregable_name as $key => $value) 
		{
			$ev_ex_name = $this->input->post('ee_name');
			$ee = $this->evaluation_exercise->get_ee_id($ev_ex_name); //Obtenemos el id del ejercicio de evaluacion actual
			$categoria = $key; //Mantenemos el id de la categoria

			//Comparamos los datos del formulario con los de la base de datos
			if ($this->input->post($value) == "on" && $this->entregable->check_entregable_on_ev_ex($ee, $categoria) == false)
			{
				$this->evaluation_exercise->add_category_to_ee($ee, $categoria); //Añadimos la categoria al ejercicio de evaluacion
			}
			if ($this->input->post($value) != "on" && $this->entregable->check_entregable_on_ev_ex($ee, $categoria) == true)
			{
				$this->evaluation_exercise->delete_category_from_ee($ee, $categoria); //Eliminamos la categoria del ejercicio de evaluacion
			}	
		}

		redirect('evaluation_exercise');
	}

	public function delete_evaluation_exercise()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');
		$this->load->model('Evaluation_exercise_model', 'evaluation_exercise');

		$evaluation_exercise=$this->input->post('evaluation_exercise_to_delete');
		
		$this->evaluation_exercise->eliminar_evaluation_exercise($evaluation_exercise);

		redirect('evaluation_exercise');
	}

	public function edit_evaluation_exercise()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');
		$this->load->model('Evaluation_exercise_model', 'evaluation_exercise');
		$this->load->model('Parametros_model', 'parametros');
 
		$datos['exercise_name'] = $this->input->post('exercise_name'); 
		$datos['evaluation_id'] = $this->input->post('evaluation_id');
		$datos['beginning'] = $this->input->post('beginning');
		$datos['first_phase_end'] = $this->input->post('first_phase_end');
		$datos['second_phase_end'] = $this->input->post('second_phase_end');
		$datos['third_phase_end'] = $this->input->post('third_phase_end');
		$datos['fourth_phase_end'] = $this->input->post('fourth_phase_end');
		$datos['description'] = $this->input->post('description');
		
		$this->evaluation_exercise->modificar_evaluation_exercise($datos);

		redirect('evaluation_exercise');
	}

	public function make_preasignations()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');
		$this->load->model('Evaluation_exercise_model', 'evaluation_exercise');
		$this->load->model('Parametros_model', 'parametros');

		$ee = $this->input->post('ee_to_preasignations');
		$this->evaluation_exercise->deteccion_de_rafagas($ee);
		$evals_per_student = $this->parametros->get_evaluaciones_por_alumno();
		$evals_per_edition = $this->parametros->get_evaluaciones_por_edicion();
		$min_editions_eval = $this->parametros->get_min_ediciones_evaluadas_por_alumno();
		$autoevaluation = $this->parametros->get_autoevaluacion();
		$users = $this->evaluation_exercise->get_users_for_ee($ee);
		$revisions = $this->evaluation_exercise->get_revisions_for_ee($ee);

		if ($min_editions_eval > 0)
		{
			$this->evaluation_exercise->preasignations_with_min ($users, $revisions, $ee, $evals_per_student, $evals_per_edition, $autoevaluation, $min_editions_eval);
		}
		else
		{	
			$this->evaluation_exercise->preasignations_no_min ($users, $revisions, $ee, $evals_per_student, $evals_per_edition, $autoevaluation);
		}
		redirect('evaluation_exercise');
	}

	public function delete_preasignations()
	{
		// Comprobamos que el usuario haya hecho login
		if (!$this->session->userdata('logged_in'))
			redirect('acceso/index');

		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));
		
		// LOAD MODEL
		$this->load->model('acceso_model', 'acceso');
		$this->load->model('Roles_model', 'roles');
		$this->load->model('Evaluation_exercise_model', 'evaluation_exercise');

		$ee = $this->input->post('ee_delete_preasignations');
		$editions = $this->evaluation_exercise->get_editions_of_ee($ee);

		foreach ($editions as $key => $value) 
		{
			$editions = $this->evaluation_exercise->delete_from_preasignations($value);
		}

		redirect('evaluation_exercise');
	}
	
}
/* End of file acceso.php */
/* Location: ./application/controlers/evaluation_exercise.php */

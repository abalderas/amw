<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entregable_model extends CI_Model 
{

	// Títulos de los entregables
    var $entregables = array();

    // Descripciones de los entregables
    var $descriptions = array();

    // Categoria generica o especifica
    var $generic_specific = false;

    private $table = 'entregables';
    private $categories = 'categorias_ej_ev';

    /// Lee de la BD todos los entregables y los vuelca en la BD
    function __construct()
    {
        // Llama al constructor del padre
        parent::__construct();

        // Pedimos todos los entregables de la base de datos
		$query = $this->db->get($this->table);

		// Volcamos el contenido de la BD en las arrays				
		foreach ($query->result() as $row)
		{
			$this->entregables[$row->ent_id] = $row->ent_entregable;
			$this->descriptions[$row->ent_id] = $row->ent_description;
			$this->generic_specific[$row->ent_id] = $row->generic_specific;
		}
	}
    
    /// Borra el entregable con el ID indicado
	function delete($id)
	{
		$this->db->delete($this->table, array('ent_id' => $id));
	}

	/// Devuelve el entregable con el ID indicado
	function get($id)
	{
		$query = $this->db->get_where($this->table, array('ent_id' => $id));
		return $query->first_row();
	}

	/// Edita el entregable con los datos indicados
	function update($data)
	{		
		log_message('error','ID: ' . $data['ent_id']);
		$this->db->where('ent_id', $data['ent_id']);
		log_message('error',$this->db->update($this->table, $data));
	}

	/// Inserta el entregable con los datos indicados
	function insert($data)
	{
		$this->db->insert($this->table, $data); 
	}

	function get_generic_specific ($value)
	{
		$result = array();
		
		$sql = 'SELECT generic_specific' .
			' FROM entregables ' .
			' WHERE ent_entregable LIKE "' . $value . '"' ;
		//echo $sql;

		$query = $this->db->query($sql);


		foreach ($query->result() as $row) 
		{
			array_push($result, $row->generic_specific);
		}

		return $result[0];
	}

	//Funcion que devuelve una lista con los id de los entregables
	function get_entregable_list ()
	{
		$result = array();

		$sql = 'SELECT ent_id' .
			' FROM entregables ';
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->ent_id);
		}

		return $result;
	}

	//Funcion que devuelve el nombre del entregable dado si ID
	function get_entregable_name ($id)
	{
		$result = array();

		$sql = 'SELECT ent_entregable' .
			' FROM entregables ' .
			' WHERE ent_id = ' . $id ;
		//echo $sql;
			
		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			array_push($result, $row->ent_entregable);
		}

		return $result[0];
	}

	//Funcion que dado un ejercicio de evaluacion y una categoria devuelve si dicha categoria es evaluada en dicho ejercicio
	function check_entregable_on_ev_ex ($ee_id, $ent_id)
	{
		$result = array();

		$sql = 'SELECT ent_id' .
			' FROM ' . $this->categories .
			' WHERE evaluation_id = ' . $ee_id ;
		//echo $sql;
		
		$query = $this->db->query($sql);

		foreach ($query->result() as $row) //Almacenamos en result todas las categorias que se evaluan en el ejercicio de evaluacion
		{
			array_push($result, $row->ent_id);
		}

		foreach ($result as $value) { //Si en los resultados encontramos la categoria que buscamos
			if ($value == $ent_id)
				return true;
		}

		return false; //Si no la encontramos
	}
}


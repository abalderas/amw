<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entregable_model extends CI_Model {

    var $entregables = array();
    var $descriptions = array();
	var $tabla = 'entregables';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->rellenar();
    }
	
	function rellenar()
	{
		
		$this->db->select('ent_id, ent_entregable, ent_description');

		$query = $this->db->get($this->tabla);
		
				
		foreach ($query->result() as $row)
		{
			$this->entregables[$row->ent_id] = $row->ent_entregable;
			$this->descriptions[$row->ent_id] = $row->ent_description;
		}
	}
    

}


<?php
class Csv_model extends CI_Model {

	private $table = 'evaluaciones_entregables';

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	function datos($id)
	{
		$data['listado'] = array();
		$data['revisions'] = array();

		$sql = "SELECT eva_id, eva_revision " .
			"FROM evaluaciones " .
			"WHERE eva_user = $id";

		$i=0;
		$query = $this->db->query($sql);
			
		foreach ($query->result() as $row)
		{
			$data['listado'][$i] = $row->eva_id;
			$data['revisions'][$i] = $row->eva_revision;
			$i++;
		}

		return $data;
    	}

	function entregables($campo)
	{
		$entregables = array();

		$sql = "SELECT $campo " .
			"FROM entregables";

		$i=0;
		$query = $this->db->query($sql);
			
		foreach ($query->result() as $row)
		{
			$entregables[$i] = $row->$campo;
			$i++;
		}

		return $entregables;
	}

	function notas($ids)
	{
		$notas = array();

		$tot = count($ids);
		for ($i=0; $i<$tot; $i++)
		{
			$sql = "SELECT ent_id, ee_nota " .
			"FROM evaluaciones_entregables " .
			"WHERE eva_id = $ids[$i]";

			$query = $this->db->query($sql);
			foreach ($query->result() as $row)
			{
				$notas[$i][$row->ent_id] = $row->ee_nota;
			}
		}
		return $notas;		
	}

}
?>

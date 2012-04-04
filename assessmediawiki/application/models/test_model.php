<?php
class Test_model extends CI_Model {

    var $tests = array();
	private $table = 'entregables';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->listing();
    }
	
	function listing()
	{	
		$query = $this->db->get($this->table);

		foreach ($query->result() as $row)
		{
			$this->tests[$row->ent_id] = $row->ent_entregable;
		}
	}
	
	function delete($id)
	{
		$this->db->delete($this->table, array('ent_id' => $id));
	}
	
	function edit($id)
	{
		$query = $this->db->get_where($this->table, array('ent_id' => $id));
		foreach ($query->result() as $row)
			$ent = $row;
		return $ent;
	}
	
	function update($data)
	{
		$this->db->where('ent_id', $data['ent_id']);
		$this->db->update($this->table, $data); 
	}
	
	function insert($data)
	{
		$this->db->insert($this->table, $data); 
	}
    

}
?>

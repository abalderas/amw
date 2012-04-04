<?php
class Reply_model extends CI_Model {
    
	var $table = 'replies';
	private $rep_id;
	private $rep_read;
	private $rep_new;
	

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function set($data)
	{
		$this->rep_id = $data['rep_id'];
		$this->rep_read = $data['rep_read'];
		$this->rep_new = $data['rep_new'];
	}
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
		$data['rep_id'] = $this->db->insert_id();
		
		// Set.
		$this->set($data);
		
		// Al insertar podemos comprobar si ya
		// existe corrección de dicho artículo para
		// no permitir una nueva.
	}
	
	function replies_amount($eval)
	{
		$c = 0;
		$this->rep_read = $eval;
		do {
			$query = $this->db->get_where($this->table, array('rep_read' => $this->rep_read));
			$registers = $query->num_rows();
			if ($registers > 0)
			{
				$c++;
				$row = $query->first_row('array');
				$this->rep_read = $row['rep_new'];
			}
		} while ($registers >0 && $c < 1000);
		
		return $c;
	}
	
	function replies_list($eval)
	{
		$re_list = array();
		$this->rep_read = $eval;
		do {
			$query = $this->db->get_where($this->table, array('rep_read' => $this->rep_read));
			$registers = $query->num_rows();
			if ($registers > 0)
			{				
				$row = $query->first_row('array');
				$this->rep_read = $row['rep_new'];
				array_push($re_list, $this->rep_read);
			}
		} while ($registers >0);
		
		return $re_list;
	}
	
	
}

?>

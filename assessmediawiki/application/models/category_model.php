<?php
class Category_model extends CI_Model {

	private $link;
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model('acceso_model', 'bd');
		$this->link = $this->bd->conectar_wiki();
    }
	
	function category()
	{
		
		$sql    = 'SELECT value '
			. 'FROM config '
			. 'WHERE parameter = \'category\'';
		$result = $this->db->query($sql);
		
		$category = $result->row();
		
		return $category->value;
	}

	function update($c)
	{
		$data = array('value'=>$c);
		$this->db->where('parameter', 'category');
		$this->db->update('config', $data);
	}
    

}
?>

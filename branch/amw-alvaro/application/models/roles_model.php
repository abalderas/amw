<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles_model extends CI_Model 
{
	function __construct(){
		parent::__construct();
	}
    
	function saveroles($roles){
		$tables = $this->db->list_tables();
		
		if(!in_array('role', $tables)){
			$this->db->query("CREATE TABLE role ( role_user VARCHAR(30) NOT NULL, role_name VARCHAR(20) NOT NULL, KEY role_user (role_user) ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
			$this->db->insert_batch('role', $roles); 
		}else{
				
			$this->db->update_batch('role', $roles, 'role_user');
		}
	}
	
	function getrole($alumno){
		if($this->db->table_exists('role')){
			$query = $this->db->query("select * from role where role_user = '$alumno'");
			
			if(!$query->result())
				return false;
			
			foreach($query->result() as $row)
				return $row->role_name;
		}
		
		return "student";
	}
}


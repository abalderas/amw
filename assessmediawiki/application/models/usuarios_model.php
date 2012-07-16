<?php
class Usuarios_model extends CI_Model {

    var $usuarios = array();
	private $link;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model('acceso_model', 'bd');
		$this->link = $this->bd->conectar_wiki();
		$this->listado();
    }
	function listado()
	{
		
		
		$sql    = 'SELECT user_id, user_name "
			. "FROM user';
		$result = mysql_query($sql, $this->link);

		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$this->usuarios[$row[0]] = $row[1];
		}
		
	}

	function users()
	{
		$usuarios = array();
		
		$sql    = 'SELECT user_id, user_name "
			. "FROM user';
		$result = mysql_query($sql, $this->link);

		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$usuarios[$row[0]] = $row[1];
		}
		return $usuarios;
	}
	
	function admin($userid)
	{
		// De momento el admin será un usuario
		//  cuya id corresponda con ésta.
		// Más adelante se mejorará ésto.
		/* IW:
		usuario dodero = 2
		mi usuario = 24
		*/
		$admin = 2;
		
		if ($userid == $admin || $userid == 38)
			return 1;
		else
			return 0;
	}
    

}
?>

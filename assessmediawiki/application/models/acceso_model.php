	<?php
class Acceso_model extends CI_Model {

    private $user;
	private $id;
	private $pass;
	private $linK;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		$this->link = $this->conectar_wiki();
    }
	
	function conectar_wiki()
	{
		
		$link =  mysql_connect('localhost', $this->config->item('username_mw'), $this->config->item('password_mw'));

		if (!$link) {
			die('No pudo conectarse: ' . mysql_error());
		}
		if (!mysql_select_db($this->config->item('database_mw'), $link)) {
			echo 'No pudo seleccionar la base de datos';
			exit;
		}
		
		return $link;
	}
	
	function userid($user)
	{		
		$this->user = $user;
		
		$sql    = 'SELECT user_id '
			. 'FROM user '
			. 'WHERE user_name like \''. $user . '\'';
			
		$result = mysql_query($sql, $this->link);

		// Si no existe ningún usuario con ese ID, devolvemos falso
		if (mysql_num_rows($result) == 0)
			return FALSE;

		while ($row = mysql_fetch_array($result)) {
			$this->id= $row[0];
		}
		return $this->id;
		
	}
	
	function username($userid)
	{		
		$this->userid = $userid;
		
		$sql    = 'SELECT user_name '
			. 'FROM user '
			. 'WHERE user_id = '. $userid;
			
		$result = mysql_query($sql, $this->link);

		while ($row = mysql_fetch_array($result)) {
			$this->user= $row[0];
		}
		return $this->user;
		
	}
	
	function userpass($user)
	{		
		$this->user = $user;
		
		$sql    = 'SELECT user_password '
			. 'FROM user '
			. 'WHERE user_name like \''. $user . '\'';
			
		$result = mysql_query($sql, $this->link);

		while ($row = mysql_fetch_array($result)) {
			$this->pass= $row[0];
		}
		return $this->pass;
		
	}
    

}
?>

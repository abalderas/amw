<?php
class Revisiones_model extends CI_Model {

	private $link;
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model('acceso_model', 'bd');
		$this->load->model('category_model', 'category');
		$this->link = $this->bd->conectar_wiki();
    }
	
	function articulos($user)
	{
		$articulos = array();
		
		$sql    = 'SELECT rev_id '
			. 'FROM revision '
			. 'WHERE rev_user = ' . $user;
		$result = mysql_query($sql, $this->link);
		
		while ($row = mysql_fetch_array($result)) {
			array_push($articulos, $row[0]);
		}
		
		return $articulos;
		
	}
	
	// Funcion que devuelve el usuario de un articulo
	function usuarioArticulo($articulo)
	{
		$sql    = 'SELECT rev_user '
			. 'FROM revision '
			. 'WHERE rev_id = ' . $articulo;
		$result = mysql_query($sql, $this->link);
		
		while ($row = mysql_fetch_array($result)) {
			$user = $row[0];
		}
		
		return $user;
	}
	
	function listado_validas($existentes, $user)
	{
		$articulos = array();
		
		// Generamos las posibilidades SQL.
		$sql_count = 'SELECT count(*) ';
		$sql_select = 'SELECT rev_id ';
		$sql_fin    = 'FROM revision, categorylinks '
			. 'WHERE rev_user <> ' . $user
			. ' AND rev_user <> 0 '
			//. ' AND rev_timestamp > ' . $this->fecha()
			. ' AND rev_id NOT IN (';
		// Tampoco puede ser el usuario 0
		// porque es el user x defecto del wiki
		foreach ($existentes as $e)
			$sql_fin .= $e . ', ';
			
		$sql_fin .= '0)';

		// Incluimos categories
		// Ademas de estas lineas se incluye en from tabla categorylinks
		$sql_fin .= "AND cl_to = '" . $this->category->category() . "'";
		$sql_fin .= "AND cl_from = rev_page";
		// terminamos categories
		
		// Primero contamos cuántas hay:
		$sql = $sql_count . $sql_fin;
		
		$result = mysql_query($sql, $this->link);
		
		while ($row = mysql_fetch_array($result)) {
			$cantidad = $row[0];
		}

		$cantidad = floor($cantidad*0.3+1);
	
		$sql = $sql_select . $sql_fin . 
			'	ORDER BY rev_len DESC LIMIT 1, ' . 
			$cantidad;
		
		$result = mysql_query($sql, $this->link);
		
		while ($row = mysql_fetch_array($result)) {
			array_push($articulos, $row[0]);
		}
		
		return $articulos;
		
	}
	
	function fecha()
	{
		$y = date("Y");
		$m = date("m");
		
		// Si m es > 9 entonces estamos en nuevo curso
		if ($m <= 9)
			$y--;
		
		$curso = $y . '0901000000';
		return $curso;
	}
	
	function realizadas($user)
	{
		$articulos = array();
		
		// Generamos las posibilidades SQL.
		$sql = 'SELECT count(*) cant ' 
			. 'FROM evaluaciones '
			. 'WHERE eva_revisor =' . $user;
			
		$result = $this->db->query($sql);
		
		$cantidad = $result->row();
		
		return $cantidad->cant;
	}
    

}
?>

<?php
class Evaluaciones_model extends CI_Model {
    
	var $tabla = 'evaluaciones';
	var $tabla_entregables = 'evaluaciones_entregables';
	private $eva_id;
	private $eva_user;
	private $eva_revision;
	

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function insertar($datos)
	{
		$this->db->insert($this->tabla, $datos);
		$this->eva_id = $this->db->insert_id();
		
		// Al insertar podemos comprobar si ya
		// existe corrección de dicho artículo para
		// no permitir una nueva.
	}
	
	function insertar_entregables($entregables, $notas, $comentarios)
	{
		foreach($entregables as $key => $value)
		{
			if (isset($value))
			{
				$datos['eva_id'] = $this->eva_id;
				$datos['ent_id'] = $key;
				$datos['ee_nota'] = $notas[$key];
				$datos['ee_comentario'] = $comentarios[$key];
				$this->db->insert($this->tabla_entregables, $datos);
			}
		}
	}
	
	function id()
	{
		return $this->eva_id;
	}
	
	function consultar_entregables($evaluacion)
	{
		$sql = 'SELECT eva_user, eva_revision, eva_revisor ' .
			' FROM evaluaciones ' .
			' where eva_id = ' . $evaluacion;
			
		$query = $this->db->query($sql);
			
		foreach ($query->result() as $row)
		{
			$data['usuario'] = $row->eva_user;
			$data['entrada'] = $row->eva_revision;
			$data['revisor'] = $row->eva_revisor;
		}
		
		$sql = 'SELECT entregables.ent_id, ent_entregable, ee_nota, ee_comentario ' .
			' FROM evaluaciones_entregables, entregables ' .
			' where entregables.ent_id = evaluaciones_entregables.ent_id ' . 
			' and eva_id = ' . $evaluacion;
			
		$query = $this->db->query($sql);
		
		//$data['id_campo'] = array();
		$data['puntuacion'] = array();
		$data['comentarios'] = array();
		$data['entregables'] = array();
		foreach ($query->result() as $row)
		{
			//$data['id_campo'][$row->ent_id] = 1;
			$data['puntuacion'][$row->ent_id] = $row->ee_nota;
			$data['comentarios'][$row->ent_id] = $row->ee_comentario;
			$data['entregables'][$row->ent_id] = $row->ent_entregable;
		}
		
		return $data;
	}
	
	function evaluados($articulos)
	{
		$revisados = array();
		
		$sql = 'SELECT eva_id, eva_revision ' .
			' FROM evaluaciones ' .
			' where eva_revision IN (';
			
		foreach ($articulos as $valor)
			$sql .= $valor . ', ';
			
		$sql .= '-1)'; // -1 me sirve para salvar la  del final
		//echo $sql;	
		
		$query = $this->db->query($sql);
			
		foreach ($query->result() as $row)
		{
			$revisados[$row->eva_id] = $row->eva_revision;
		}
		
		return $revisados;
	}
	
	function listado()
	{
		$revisados = array();
		$this->db->select('eva_revision');
		$query = $this->db->get($this->tabla);
		foreach ($query->result() as $row)
			array_push($revisados, $row->eva_revision);
		
		return $revisados;
	}
    

}
?>
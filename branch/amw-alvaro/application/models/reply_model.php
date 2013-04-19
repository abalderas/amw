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
	
    // Guarda en variables privadas los datos recibidos por parámetros
	function set($data)
	{
		$this->rep_id = $data['rep_id'];
		$this->rep_read = $data['rep_read'];
		$this->rep_new = $data['rep_new'];
	}
	
	/// Inserta en la BD una nueva corrección
	function insert($data)
	{
		// Inserta en la BD los datos indicados
		// TODO: Hacer alguna clase de comprobación de los datos recibidos
		$this->db->insert($this->table, $data);

		// TODO: Comprobar que se ha hecho la introducción correctamente

		// Leemos la ID de la inserción realizada
		$data['rep_id'] = $this->db->insert_id();
		
		// Pasamos los datos a las variables privadas del modelo
		$this->set($data);
		
		// Al insertar podemos comprobar si ya
		// existe corrección de dicho artículo para
		// no permitir una nueva.
	}
	
	/// Devuelve el número de replies asociados a una evaluacion
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
	
	/// Devuelve la lista de replies asociadas a una evaluación
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
	
	function student_replies_list($student = false)
	{
		if($student){
			$query = $this->db->query("select rep_id, rep_status, eva_user, eva_revisor, eva_revision, ee_nota, ee_comentario from replies, evaluaciones, evaluaciones_entregables where rep_read = evaluaciones.eva_id and rep_read = `evaluaciones_entregables`.eva_id and eva_user = '$student'");
		}else{
			$query = $this->db->query("select rep_id, rep_status, eva_user, eva_revisor, eva_revision, ee_nota, ee_comentario from replies, evaluaciones, evaluaciones_entregables where rep_read = evaluaciones.eva_id and rep_read = `evaluaciones_entregables`.eva_id");
		}
		
		$result = $query->result();
		if($result){
			foreach($result as $row)
				$replies[] = array('rep_id' => $row->rep_id, 'eva_user' => $row->eva_user, 'eva_revisor' => $row->eva_revisor, 'eva_revision' => $row->eva_revision, 'ee_nota' => $row->ee_nota, 'ee_comentario' => $row->ee_comentario, 'rep_status' => $row->rep_status);
			return $replies;
		}else
			return false;
	}
	
	function student_replies_out_list($student = false)
	{
		if($student){
			$query = $this->db->query("select rep_id, rep_status, eva_user, eva_revisor, eva_revision, ee_nota, ee_comentario from replies, evaluaciones, evaluaciones_entregables where rep_read = evaluaciones.eva_id and rep_read = `evaluaciones_entregables`.eva_id and eva_revisor = '$student'");
		}else{
			$query = $this->db->query("select rep_id, rep_status, eva_user, eva_revisor, eva_revision, ee_nota, ee_comentario from replies, evaluaciones, evaluaciones_entregables where rep_read = evaluaciones.eva_id and rep_read = `evaluaciones_entregables`.eva_id");
		}
		
		$result = $query->result();
		if($result){
			foreach($result as $row)
				$replies[] = array('rep_id' => $row->rep_id, 'eva_user' => $row->eva_user, 'eva_revisor' => $row->eva_revisor, 'eva_revision' => $row->eva_revision, 'ee_nota' => $row->ee_nota, 'ee_comentario' => $row->ee_comentario, 'rep_status' => $row->rep_status);
			return $replies;
		}else
			return false;
	}
	
	function arbitred_replies()
	{
		$query = $this->db->query("select rep_id, rep_status, eva_user, eva_revisor, eva_revision, ee_nota, ee_comentario from replies, evaluaciones, evaluaciones_entregables where rep_read = evaluaciones.eva_id and rep_read = `evaluaciones_entregables`.eva_id and replies.rep_status != 'nonarbitred'");
		
		$result = $query->result();
		if($result){
			foreach($result as $row)
				$replies[] = array('rep_id' => $row->rep_id, 'eva_user' => $row->eva_user, 'eva_revisor' => $row->eva_revisor, 'eva_revision' => $row->eva_revision, 'ee_nota' => $row->ee_nota, 'ee_comentario' => $row->ee_comentario, 'rep_status' => $row->rep_status);
			return $replies;
		}else
			return false;
	}
	
	function nonarbitred_replies()
	{
		$query = $this->db->query("select rep_id, rep_status, eva_user, eva_revisor, eva_revision, ee_nota, ee_comentario from replies, evaluaciones, evaluaciones_entregables where rep_read = evaluaciones.eva_id and rep_read = `evaluaciones_entregables`.eva_id and replies.rep_status = 'nonarbitred'");
		
		$result = $query->result();
		if($result){
			foreach($result as $row)
				$replies[] = array('rep_id' => $row->rep_id, 'eva_user' => $row->eva_user, 'eva_revisor' => $row->eva_revisor, 'eva_revision' => $row->eva_revision, 'ee_nota' => $row->ee_nota, 'ee_comentario' => $row->ee_comentario, 'rep_status' => $row->rep_status);
			return $replies;
		}else
			return false;
	}
	
	function accept_reply($repid){
		$data = array('rep_status' => 'accepted');

		$this->db->where('rep_id', $repid);
		$this->db->update('replies', $data); ;
	}
	
	function deny_reply($repid){
		$data = array('rep_status' => 'denied');

		$this->db->where('rep_id', $repid);
		$this->db->update('replies', $data); ;
	}
}

?>

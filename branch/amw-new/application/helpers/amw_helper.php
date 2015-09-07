<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('wiki_revision_url'))
{
	/// Devuelve la URL de una revisión en el wiki, utilizando la URL base configurada en los parámetros
    function wiki_revision_url($rev)
    {
	    // Referencia al objeto CI
	    $CI = get_instance();

	    // Cargamos el modelo de parámetros
	    $CI->load->model('Parametros_model', 'parametros');
	    $CI->load->model('Evaluation_exercise_model', 'evaluation_exercise');

	    //Si es una rafaga la url terminara con la id de la edicion final, si no terminara con prev
		$fin_url = $CI->evaluation_exercise->buscar_fin_rafaga($rev);
		
		if ($fin_url == $rev || $fin_url == 0) 
		{
			$fin_url = "prev";
		}	    

	    // Construimos la URL
	    $baseURL = $CI->parametros->get_wiki_url() . "index.php?oldid=" . $rev . "&diff=" . $fin_url;

	    return $baseURL;
    }   
}

/* End of file filename.php */
/* Location: ./application/folder/filename.php */
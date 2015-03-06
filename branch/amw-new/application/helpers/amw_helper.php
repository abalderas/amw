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

	    // Construimos la URL
	    $baseURL = $CI->parametros->get_wiki_url() . "index.php?oldid=" . $rev . "&diff=prev";

	    return $baseURL;
    }   
}

/* End of file filename.php */
/* Location: ./application/folder/filename.php */
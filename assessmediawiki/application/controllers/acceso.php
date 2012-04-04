<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acceso extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		 // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation'));

        // LOAD HELPERS
        $this->load->helper(array('form', 'url'));

		// SET VALIDATION RULES
		$this->form_validation->set_rules('user_name', 'username', 'required');
		$this->form_validation->set_rules('user_pass', 'password', 'required');
		$this->form_validation->set_error_delimiters('<em>','</em>');

		// Carga del modelo de acceso
		$this->load->model('acceso_model', 'acceso');
		
		
		// has the form been submitted and with valid form info (not empty values)
		if($this->input->post('login'))
		{
		    if($this->form_validation->run())
		    {
				$user_name = $this->input->post('user_name');		
				$user_name = ucfirst($user_name);
        		$user_pass = $this->input->post('user_pass');

		        if($user_name!=' ' && $user_pass!=' ')
        		{
					$user_id = $this->acceso->userid($user_name);
					
					// Cogido de media wiki
					
					$hash = $this->acceso->userpass($user_name);
					$m = false;
					$type = substr( $hash, 0, 3 );
					
					$acceso = 0;

					if ( $type == ':A:' ) {
						# Unsalted
						if (md5( $user_pass ) === substr( $hash, 3 ))
							$acceso = 1;
					} elseif ( $type == ':B:' ) {
						# Salted
						list( $salt, $realHash ) = explode( ':', substr( $hash, 3 ), 2 );
						if (md5( $salt.'-'.md5( $user_pass ) ) == $realHash)						
							$acceso = 1;
					} else {
						# Old-style
						if (md5($user_pass) === $hash)
							$acceso = 1;
					}

					// fin de mediawiki
					
            		if ($acceso == 1)
					{
						
                		// Creamos la sesión
						$newdata = array(
		                   'username'  => $user_name,
						   'userid'  => $user_id,   
		                   'logged_in' => TRUE
		                );

						$this->session->set_userdata($newdata);
						
                		redirect('evaluar/index');
            		}

        		}
        		else
        		{
            		$this->session->set_flashdata('message', 'Usuario o contraseña no válidos.');
            		redirect('acceso/index/');
        		}
				
    		}
		}
		$this->load->view('template/header');
		$this->load->view('acceso_formulario');
		$this->load->view('template/footer');
	}

	public function salir()
	{
		$this->session->unset_userdata('logged_in');
		redirect('acceso/index/');
	}
}

/* End of file acceso.php */
/* Location: ./application/controllers/acceso.php */

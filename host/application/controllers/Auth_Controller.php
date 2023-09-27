<?php
class Auth_Controller extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        if($this->ion_auth->logged_in()===FALSE)
        {
            redirect('user/login');
        }
    }
    protected function render($the_view = NULL, $template = 'auth_master')
    {
        parent::render($the_view, $template);
    }
}
?>